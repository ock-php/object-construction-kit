<?php

declare(strict_types=1);

namespace Donquixote\Ock\Tests;

use Donquixote\Ock\Tests\Translator\Translator_Test;
use Donquixote\Ock\Tests\Util\XmlTestUtil;
use Donquixote\Ock\Text\TextInterface;
use Donquixote\Ock\Translator\Translator_Passthru;
use PHPUnit\Framework\TestCase;

class TextTest extends TestCase {

  /**
   * Tests various formulas.
   *
   * @param string $name
   *   File containing the expected generated code.
   *
   * @dataProvider providerText()
   */
  public function testText(string $name): void {
    $dir = dirname(__DIR__) . '/fixtures/text';
    $text = include "$dir/$name.php";
    if (!$text instanceof TextInterface) {
      self::fail('Text must implement TextInterface.');
    }

    XmlTestUtil::assertXmlFileContents(
      "$dir/$name.html",
      $text->convert(new Translator_Passthru()));

    if (file_exists($file = "$dir/$name.t.html")) {
      XmlTestUtil::assertXmlFileContents(
        $file,
        $text->convert(new Translator_Test()));
    }
  }

  /**
   * Data provider.
   *
   * @return \Iterator
   *   Parameter combos.
   */
  public function providerText(): \Iterator {
    $dir = dirname(__DIR__) . '/fixtures/text';
    $names_map = [];
    foreach (scandir($dir) as $candidate) {
      if (preg_match('@^(\w+)\.\w+$@', $candidate, $m)) {
        $names_map[$m[1]] = TRUE;
      }
    }
    foreach ($names_map as $name => $_) {
      yield [$name];
    }
  }

}
