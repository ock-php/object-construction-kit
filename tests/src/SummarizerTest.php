<?php

declare(strict_types=1);

namespace Ock\Ock\Tests;

use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Summarizer\Summarizer;
use Ock\Ock\Tests\Fixture\IntOp\IntOpInterface;
use Ock\Ock\Tests\Translator\Translator_Test;
use Ock\Ock\Tests\Util\TestingServices;
use Ock\Ock\Tests\Util\XmlTestUtil;
use Ock\Ock\Translator\Translator_Passthru;
use Symfony\Component\Yaml\Yaml;

class SummarizerTest extends FormulaTestBase {

  /**
   * Tests various formulas.
   *
   * @param string $base
   * @param string $case
   *
   * @throws \Exception
   * @throws \Psr\Container\ContainerExceptionInterface
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

    $summarizer = Summarizer::fromFormula($formula, $adapter);
    $summary = $summarizer->confGetSummary($conf);

    XmlTestUtil::assertXmlFileContents(
      "$dir/$base.$case.html",
      $summary?->convert(new Translator_Passthru()) ?? '?',
    );

    XmlTestUtil::assertXmlFileContents(
      "$dir/$base.$case.t.html",
      $summary?->convert(new Translator_Test()) ?? '?',
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
   * @throws \Exception
   * @throws \Psr\Container\ContainerExceptionInterface
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

    $summarizer = Summarizer::fromIface($interface, $adapter);
    $summary = $summarizer->confGetSummary($conf);
    self::assertNotNull($summary);

    XmlTestUtil::assertXmlFileContents(
      "$filebase.html",
      $summary->convert(new Translator_Passthru()),
    );

    if (file_exists($file = "$filebase.t.html")) {
      XmlTestUtil::assertXmlFileContents(
        $file,
        $summary->convert(new Translator_Test()),
      );
    }
  }

}
