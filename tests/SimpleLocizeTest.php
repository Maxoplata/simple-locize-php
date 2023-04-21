<?php

namespace Maxoplata\Tests;

use PHPUnit\Framework\TestCase;
use Maxoplata\SimpleLocize;

$dotenv = \Dotenv\Dotenv::createMutable(__DIR__ . '/..');
$dotenv->load();

class SimpleLocizeTest extends TestCase
{
	private $locizePublic = null;
	private $locizePrivate = null;

	public function setUp(): void
	{
		$this->locizePublic = new SimpleLocize($_ENV['LOCIZE_PROJECT_ID'], $_ENV['LOCIZE_ENVIRONMENT']);
		$this->locizePrivate = new SimpleLocize($_ENV['LOCIZE_PROJECT_ID'], $_ENV['LOCIZE_PRIVATE_ENVIRONMENT'], $_ENV['LOCIZE_PRIVATE_KEY']);
	}

	public function testGetAllTranslationsFromNamespacePublic(): void
	{
		$test1 = $this->locizePublic->getAllTranslationsFromNamespace($_ENV['LOCIZE_NAMESPACE'], 'en');
		$test2 = $this->locizePublic->getAllTranslationsFromNamespace($_ENV['LOCIZE_NAMESPACE'], 'es');

		$this->assertEquals('One', $test1->one);
		$this->assertEquals('Uno', $test2->one);
		$this->assertEquals('Two Three', $test1->two->three);
		$this->assertEquals('Dos Tres', $test2->two->three);
		$this->assertEquals('Four Five Six', $test1->four->five->six);
		$this->assertEquals('Quattro Cinco Seis', $test2->four->five->six);
	}

	public function translatePublic(): void
	{
		$test1 = $this->locizePublic->translate($_ENV['LOCIZE_NAMESPACE'], 'en', 'one');
		$test2 = $this->locizePublic->translate($_ENV['LOCIZE_NAMESPACE'], 'es', 'one');
		$test3 = $this->locizePublic->translate($_ENV['LOCIZE_NAMESPACE'], 'en', 'two.three');
		$test4 = $this->locizePublic->translate($_ENV['LOCIZE_NAMESPACE'], 'es', 'two.three');
		$test5 = $this->locizePublic->translate($_ENV['LOCIZE_NAMESPACE'], 'en', 'four.five.six');
		$test6 = $this->locizePublic->translate($_ENV['LOCIZE_NAMESPACE'], 'es', 'four.five.six');

		$this->assertEquals('One', $test1);
		$this->assertEquals('Uno', $test2);
		$this->assertEquals('Two Three', $test3);
		$this->assertEquals('Dos Tres', $test4);
		$this->assertEquals('Four Five Six', $test5);
		$this->assertEquals('Quattro Cinco Seis', $test6);
	}

	public function testGetAllTranslationsFromNamespacePrivate(): void
	{
		$test1 = $this->locizePrivate->getAllTranslationsFromNamespace($_ENV['LOCIZE_NAMESPACE'], 'en');
		$test2 = $this->locizePrivate->getAllTranslationsFromNamespace($_ENV['LOCIZE_NAMESPACE'], 'es');

		$this->assertEquals('One', $test1->one);
		$this->assertEquals('Uno', $test2->one);
		$this->assertEquals('Two Three', $test1->two->three);
		$this->assertEquals('Dos Tres', $test2->two->three);
		$this->assertEquals('Four Five Six', $test1->four->five->six);
		$this->assertEquals('Quattro Cinco Seis', $test2->four->five->six);
	}

	public function translatePrivate(): void
	{
		$test1 = $this->locizePrivate->translate($_ENV['LOCIZE_NAMESPACE'], 'en', 'one');
		$test2 = $this->locizePrivate->translate($_ENV['LOCIZE_NAMESPACE'], 'es', 'one');
		$test3 = $this->locizePrivate->translate($_ENV['LOCIZE_NAMESPACE'], 'en', 'two.three');
		$test4 = $this->locizePrivate->translate($_ENV['LOCIZE_NAMESPACE'], 'es', 'two.three');
		$test5 = $this->locizePrivate->translate($_ENV['LOCIZE_NAMESPACE'], 'en', 'four.five.six');
		$test6 = $this->locizePrivate->translate($_ENV['LOCIZE_NAMESPACE'], 'es', 'four.five.six');

		$this->assertEquals('One', $test1);
		$this->assertEquals('Uno', $test2);
		$this->assertEquals('Two Three', $test3);
		$this->assertEquals('Dos Tres', $test4);
		$this->assertEquals('Four Five Six', $test5);
		$this->assertEquals('Quattro Cinco Seis', $test6);
	}
}
