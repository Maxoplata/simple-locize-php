<?php

namespace Maxoplata;

class SimpleLocize
{
	private $projectId = null;
	private $environment = null;
	private $privateKey = null;

	private $translations = [];

	public function __construct($projectId, $environment, $privateKey = null)
	{
		if (!$projectId) {
			throw new \Exception('No project ID provided');
		} elseif (!$environment) {
			throw new \Exception('No environment provided');
		}

		$this->projectId = $projectId;
		$this->environment = $environment;
		$this->privateKey =  $privateKey;
	}

	private function fetchFromLocize($namespace, $language)
	{
		try {
			// API URL
			$url = 'https://api.locize.io/' . (!is_null($this->privateKey) ? 'private/' : '') . "{$this->projectId}/{$this->environment}/{$language}/{$namespace}";

			// init cURL resource
			$ch = curl_init($url);

			// set auth header
			$headers = ["Authorization: {$this->privateKey}"];

			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			// set return type json
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			// execute request
			$result = curl_exec($ch);

			// close cURL resource
			curl_close($ch);

			// decode JSON
			$response = json_decode($result);

			// update translations
			$this->translations[$namespace][$language] = $response;
		} catch (\Exception $e) {
			// fail
		}
	}

	public function getAllTranslationsFromNamespace($namespace, $language)
	{
		if (!isset($this->translations[$namespace][$language])) {
			$this->fetchFromLocize($namespace, $language);
		}

		return isset($this->translations[$namespace][$language]) ? $this->translations[$namespace][$language] : (new \stdClass());
	}

	public function translate($namespace, $language, $key)
	{
		if (!isset($this->translations[$namespace][$language])) {
			$this->fetchFromLocize($namespace, $language);
		}

		$keySplit = explode('.', $key);

		$keyValue = count($keySplit) === 1
			? ($this->translations[$namespace][$language]->$key ?? null)
			: array_reduce($keySplit, function ($acc, $item) {
				return $acc->$item ?? (new \stdClass());
			}, $this->translations[$namespace][$language] ?? new \stdClass());

		return gettype($keyValue) === 'string' ? $keyValue : $key;
	}
}
