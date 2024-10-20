<?php

declare(strict_types=1);

namespace Ock\Ock\Tests;

use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\CodegenTools\CodeFormatter;
use Ock\CodegenTools\Util\PhpUtil;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Exception\GeneratorException;
use Ock\Ock\Generator\Generator;
use Ock\Ock\Generator\GeneratorInterface;
use Ock\Ock\Tests\Fixture\IntOp\IntOpInterface;
use Ock\Ock\Tests\Util\TestingServices;
use Ock\Ock\Tests\Util\TestUtil;
use Symfony\Component\Yaml\Yaml;

class GeneratorTest extends FormulaTestBase {

  /**
   * Tests various formulas.
   *
   * @param string $base
   * @param string $case
   *
   * @dataProvider providerTestFormulaCases()
   */
  public function testFormula(string $base, string $case): void {
    $dir = dirname(__DIR__) . '/fixtures/formula';
    $formula = include "$dir/$base.php";
    if (!$formula instanceof FormulaInterface) {
      self::fail('Formula must implement FormulaInterface.');
    }
    $conf = Yaml::parseFile("$dir/$base.$case.yml");

    $container = TestingServices::getContainer();
    $adapter = $container->get(UniversalAdapterInterface::class);

    $generator = Generator::fromFormula($formula, $adapter);
    $this->doTestGenerator(
      $generator,
      $conf,
      "$dir/$base.$case.php",
      null,
    );
  }

  /**
   * Tests an interface generator with a specific example.
   *
   * @param string $type
   *   Short id identifying the interface.
   * @param string $name
   *   Name of the test case.
   *
   * @dataProvider providerTestIface()
   */
  public function testIface(string $type, string $name): void {
    /** @var class-string $interface */
    $interface = strtr(IntOpInterface::class, ['IntOp' => $type]);
    $filebase = dirname(__DIR__) . '/fixtures/iface/' . $type . '/' . $name;
    $conf = Yaml::parseFile($filebase . '.yml');

    $container = TestingServices::getContainer();
    $adapter = $container->get(UniversalAdapterInterface::class);

    $generator = Generator::fromIface($interface, $adapter);
    $this->doTestGenerator(
      $generator,
      $conf,
      $filebase . '.php',
      $interface);
  }

  /**
   * @param \Ock\Ock\Generator\GeneratorInterface $generator
   * @param mixed $conf
   * @param string $file_expected
   * @param string|null $interface
   */
  private function doTestGenerator(GeneratorInterface $generator, mixed $conf, string $file_expected, ?string $interface): void {
    try {
      $php_raw = $generator->confGetPhp($conf);
    }
    catch (GeneratorException $e) {
      self::assertExceptionPhpFile($e, $file_expected);
      return;
    }
    self::assertValuePhpFile($php_raw, $interface, $file_expected);
  }

  /**
   * @param \Ock\Ock\Exception\GeneratorException $e
   * @param string $file_expected
   */
  private static function assertExceptionPhpFile(GeneratorException $e, string $file_expected): void {
    $class = get_class($e);
    $message_php = var_export($e->getMessage(), TRUE);
    $php_statement = <<<EOT
// Exception thrown in generator.
return static function () {
  throw new \\$class(
    $message_php);
};
EOT;
    $php_actual = self::formatAsFile($php_statement);
    TestUtil::assertFileContents($file_expected, $php_actual);
  }

  /**
   * @param string $expression
   *   PHP value expression.
   * @param string|null $interface
   *   Interface of the value.
   * @param string $file_expected
   *   Php file containing the expected php code.
   */
  private static function assertValuePhpFile(string $expression, ?string $interface, string $file_expected): void {
    $php_statement = PhpUtil::buildReturnStatement($expression);
    if ($interface !== NULL) {
      $php_statement = <<<EOT
return static function (): \\$interface {
  $php_statement
};
EOT;
    }
    $php_actual = self::formatAsFile($php_statement);
    TestUtil::assertFileContents($file_expected, $php_actual);
  }

  /**
   * Formats PHP code as a PHP file.
   *
   * @param string $php
   *   PHP code.
   *
   * @return string
   *   PHP code suitable for export into a file.
   */
  private static function formatAsFile(string $php): string {
    return CodeFormatter::create()
      ->withMaxLineLength(60)
      ->formatAsFile($php);
  }

}
