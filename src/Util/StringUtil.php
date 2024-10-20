<?php

declare(strict_types=1);

namespace Ock\Ock\Util;

final class StringUtil extends UtilBase {

  /**
   * @param string $search
   * @param string $delim
   * @param string[] $replacements
   *
   * @return string
   */
  public static function regex(string $search, string $delim, array $replacements = []): string {
    $regex = preg_quote($search, $delim);
    $regex = strtr($regex, $replacements);
    return $delim . $regex . $delim;
  }

  /**
   * @param string $haystack
   * @param string $needle
   *
   * @return string|false
   */
  public static function clipPrefixOrFalse(string $haystack, string $needle): bool|string {

    $l = \strlen($needle);

    if (0 !== strncmp($haystack, $needle, $l)) {
      return FALSE;
    }

    return substr($haystack, $l);
  }

  /**
   * @param callable(string): list<string> $split
   * @param string $glue
   * @param ?callable(string): string $each
   *
   * @return callable(string): string
   */
  public static function fnSplitJoin(callable $split, string $glue, callable $each = null): callable {
    return static function (string $string) use ($split, $glue, $each): string {
      $parts = $split($string);
      if ($each) {
        $parts = \array_map($each, $parts);
      }
      return \implode($glue, $parts);
    };
  }

  /**
   * @param string $example_string
   *
   * @return callable(string): list<string>
   */
  public static function fnCamelExplode(string $example_string = 'AA Bc'): callable {
    static $fn_by_example = [];
    return $fn_by_example[$example_string] ??= self::fnCamelExplodeByRegex(
      self::camelCaseExplodeExampleToRegex($example_string),
    );
  }

  /**
   * @param string $regex
   *
   * @return callable(string): list<string>
   */
  private static function fnCamelExplodeByRegex(string $regex): callable {
    return static function (string $string) use ($regex) {
      $parts = preg_split(
        $regex,
        $string,
        -1,
        PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE,
      );
      if ($parts === false) {
        throw new \RuntimeException("Failed to split '$string' using '$regex'.");
      }
      return $parts;
    };
  }

  /**
   * @param string $glue
   *
   * @return callable(string): list<string>
   */
  public function fnExplode(string $glue): callable {
    return static fn (string $string) => explode($glue, $string);
  }

  /**
   * Splits a camel-case string into its parts.
   *
   * Credits:
   *   - Charl van Niekerk,
   *     http://blog.charlvn.za.net/2007/11/php-camelcase-explode-20.html.
   *   - Andreas Hennings / dqxtech
   *     http://dqxtech.net/blog/2011-03-04/php-camelcaseexplode-xl-version.
   *
   * @param string $string
   *   The original string, that we want to explode.
   * @param bool $lowercase
   *   Should the result be lowercased?
   * @param string $example_string
   *   Example to specify how to deal with multiple uppercase characters.
   *   Can be something like "AA Bc" or "A A Bc" or "AABc".
   * @param bool|string $glue
   *   Allows to implode the fragments with sth like "_" or "." or " ".
   *   If $glue is FALSE, it will just return an array.
   *
   * @return string|string[]
   * @phpstan-return ($glue is false ? string[] : string)
   */
  public static function camelCaseExplode(string $string, bool $lowercase = true, string $example_string = 'AA Bc', bool|string $glue = false): array|string {
    static $regexp_by_example = [];
    if (!isset($regexp_by_example[$example_string])) {
      $regexp_by_example[$example_string] = self::camelCaseExplodeExampleToRegex($example_string);
    }
    $array = self::camelCaseExplodeWithRegex($regexp_by_example[$example_string], $string);
    if ($lowercase) {
      $array = array_map('strtolower', $array);
    }
    return \is_string($glue) ? implode($glue, $array) : $array;
  }

  /**
   * @param string $regexp
   * @param string $string
   *
   * @return string[]
   */
  public static function camelCaseExplodeWithRegex(string $regexp, string $string): array {
    $parts = preg_split($regexp, $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
    if ($parts === false) {
      throw new \RuntimeException("Failed to split '$string' with '$regexp'.");
    }
    return $parts;
  }

  /**
   * @param string $example_string
   *
   * @return string
   *   Regular expression to use.
   */
  public static function camelCaseExplodeExampleToRegex(string $example_string): string {
    static $regexp_available = [
      '/([A-Z][^A-Z]*)/',
      '/([A-Z][^A-Z]+)/',
      '/([A-Z]+[^A-Z]*)/',
    ];
    $orig = str_replace(' ', '', $example_string);
    $expected_exploded = explode(' ', $example_string);
    foreach ($regexp_available as $regexp) {
      $actual_exploded = self::camelCaseExplodeWithRegex($regexp, $orig);
      if ($expected_exploded === $actual_exploded) {
        return $regexp;
      }
    }
    throw new \InvalidArgumentException('Invalid example string.');
  }

  /**
   * @param string $interface
   *
   * @return string
   */
  public static function interfaceGenerateLabel(string $interface): string {
    $title = $interface;
    if (FALSE !== $pos = strrpos($title, '\\')) {
      $title = substr($title, $pos + 1);
    }
    if (\str_ends_with($title, 'Interface') && 'Interface' !== $title) {
      $title = substr($title, 0, -9);
    }
    return self::methodNameGenerateLabel($title);
  }

  /**
   * @param string $class
   *
   * @return string
   */
  public static function classGetShortname(string $class): string {
    return (FALSE !== $pos = strrpos($class, '\\'))
      ? substr($class, $pos + 1)
      : $class;
  }

  /**
   * @param string $methodName
   *
   * @return string
   */
  public static function methodNameGenerateLabel(string $methodName): string {
    $parts = \explode('_', $methodName);
    foreach ($parts as &$part) {
      if ($part === '') {
        $part = '-';
      }
      else {
        $sub_parts = \preg_split(
          '/([A-Z][^A-Z]+)/',
          $part,
          -1,
          \PREG_SPLIT_NO_EMPTY | \PREG_SPLIT_DELIM_CAPTURE,
        );
        if ($sub_parts === false) {
          throw new \RuntimeException("Failed to sub-split '$part' of '$methodName'.");
        }
        $part = \strtolower(\implode(' ', $sub_parts));
      }
    }
    return \ucfirst(\implode(' ', $parts));
  }

}
