<?php

declare(strict_types=1);

namespace Ock\Ock\Tests\Util;

use PHPUnit\Util\Xml\Loader;

class XmlTestUtil {

  /**
   * List of tags to be considered inline.
   *
   * The only purpose is to determine whether it is safe to insert line breaks.
   */
  const INLINE_TAGS = [
    // Pseudo-tag for translation.
    't',
    'em',
  ];

  /**
   * List of tags that can be written as empty tags, e.g. '<br/>'.
   */
  const EMPTY_TAGS = [
    'br',
    'hr',
  ];

  /**
   * @param string $file
   * @param string $xml_fragment_actual
   *
   * @throws \PHPUnit\Util\Xml\Exception
   * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
   * @throws \PHPUnit\Framework\ExpectationFailedException
   */
  public static function assertXmlFileContents(string $file, string $xml_fragment_actual): void {
    $xml_fragment_normalized = self::normalizeXmlFragment($xml_fragment_actual);
    TestUtil::assertFileContents($file, $xml_fragment_normalized);
  }

  /**
   * @param string $fragment
   *
   * @return string
   */
  public static function normalizeXmlFragment(string $fragment): string {

    // Guarantee wrapper tags.
    $xml = "<div>$fragment</div>";

    // Create a DOMDocument.
    /* @see \PHPUnit\Framework\Assert::assertXmlStringEqualsXmlString() */
    $document = (new Loader())->load($xml);

    // Get normalized XML string from the document.
    /* @see \SebastianBergmann\Comparator\DOMNodeComparator::nodeToText() */
    $xml = $document->C14N();
    $document = new \DOMDocument();
    try {
      @$document->loadXML($xml);
    }
    catch (\ValueError $e) {
      // Ignore the error.
      unset($e);
    }
    $document->formatOutput = FALSE;
    $document->normalizeDocument();
    $xml = self::formatChildren($document->childNodes[0], '');
    return $xml . "\n";
  }

  /**
   * @param \DOMNode $node
   * @param string $indent
   *
   * @return string
   */
  public static function formatChildren(\DOMNode $node, string $indent): string {
    $parts = [];
    foreach ($node->childNodes as $childNode) {
      $parts[] = self::formatNode($childNode, $indent);
    }
    $glue = self::nodeHasInlineContent($node)
      ? ''
      : "\n" . $indent;
    return implode($glue, $parts);
  }

  /**
   * @param \DOMNode $node
   * @param string $indent
   *
   * @return string
   *   The node formatted as XML snippet.
   */
  public static function formatNode(\DOMNode $node, string $indent): string {
    if (!$node instanceof \DOMElement) {
      $xml = $node->ownerDocument->saveXML($node);
      assert($xml !== false);
      return $xml;
    }
    if (!count($node->childNodes)) {
      $xml = $node->ownerDocument->saveXML(
        $node,
        in_array($node->tagName, self::EMPTY_TAGS)
          ? NULL
          : LIBXML_NOEMPTYTAG);
      assert($xml !== false);
      return $xml;
    }
    if (!self::nodeHasInlineContent($node)) {
      $content = "\n  " . $indent
        . self::formatChildren($node, $indent . '  ')
        . "\n" . $indent;
    }
    else {
      $content = self::formatChildren($node, $indent);
    }
    $clone = $node->cloneNode();
    $clone->appendChild(new \DOMText('#'));
    $xml = $clone->ownerDocument->saveXML($clone);
    assert($xml !== false);
    $pos = strrpos($xml, '#');
    assert($pos !== false);
    $xml = substr_replace($xml, $content, $pos, 1);
    return $xml;
  }

  /**
   * @param \DOMNode $node
   *
   * @return bool
   */
  public static function nodeHasInlineContent(\DOMNode $node): bool {
    foreach ($node->childNodes as $childNode) {
      if ($childNode instanceof \DOMText) {
        return TRUE;
      }
      if ($childNode instanceof \DOMElement) {
        if (in_array(strtolower($childNode->tagName), self::INLINE_TAGS)) {
          return TRUE;
        }
      }
    }
    return FALSE;
  }

}
