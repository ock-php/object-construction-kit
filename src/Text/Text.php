<?php

declare(strict_types=1);

namespace Ock\Ock\Text;

/**
 * Utility class with static methods.
 */
class Text {

  /**
   * @return \Ock\Ock\Text\TextBuilder
   */
  public static function builder(): TextBuilder {
    return new TextBuilder();
  }

  /**
   * @param \Ock\Ock\Text\TextInterface $text
   *
   * @return \Ock\Ock\Text\TextBase
   */
  public static function fluent(TextInterface $text): TextBase {
    return $text instanceof TextBase
      ? $text
      : new Text_FluentDecorator($text);
  }

  /**
   * Builds a text object for "Label: Value".
   *
   * @param \Ock\Ock\Text\TextInterface $label
   *   Label.
   * @param \Ock\Ock\Text\TextInterface $value
   *   Value.
   *
   * @return \Ock\Ock\Text\TextInterface
   */
  public static function label(TextInterface $label, TextInterface $value): TextInterface {
    return static::t('@label: @value', [
      '@label' => $label,
      '@value' => $value,
    ]);
  }

  /**
   * Builds a text object for a translatable string, or NULL.
   *
   * This shortcut allows for simple expressions with ??.
   *
   * @param string|null $string
   *   String to be translated, or NULL.
   * @param array $replacements
   *
   * @return \Ock\Ock\Text\TextBuilderBase|null
   *   Text object, or NULL if the original string was NULL.
   */
  public static function tOrNull(?string $string, array $replacements = []): ?TextBuilderBase {
    return ($string !== NULL)
      ? static::t($string, $replacements)
      : NULL;
  }

  /**
   * Gets a translatable text object.
   *
   * @param string $string
   *   Original untranslated text with placeholders.
   * @param \Ock\Ock\Text\TextInterface[] $replacements
   *   Replacements.
   *
   * @return \Ock\Ock\Text\TextBuilderBase
   *   Translatable text object.
   */
  public static function t(string $string, array $replacements = []): TextBuilderBase {
    $text = new Text_Translatable($string);
    if ($replacements) {
      $text = new Text_Replacements($text, $replacements);
    }
    return $text;
  }

  /**
   * Gets a non-translatable text object.
   *
   * @param string $string
   *   Original language-neutral text with placeholders.
   * @param \Ock\Ock\Text\TextInterface[] $replacements
   *   Replacements.
   *
   * @return \Ock\Ock\Text\TextBuilderBase
   *   Text object.
   */
  public static function s(string $string, array $replacements = []): TextBuilderBase {
    $text = new Text_Raw($string);
    if ($replacements) {
      $text = new Text_Replacements($text, $replacements);
    }
    return $text;
  }

  public static function sprintf(string $string, TextInterface ...$replacements): TextBase {
    return new Text_Vsprintf($string, $replacements);
  }

  public static function tIf(string $string, bool $translate, array $replacements = []): TextBuilderBase {
    return $translate
      ? static::t($string, $replacements)
      : static::s($string, $replacements);
  }

  /**
   * Builds a text object for an integer number.
   *
   * @param int $number
   *   Integer number.
   *
   * @return \Ock\Ock\Text\TextBuilderBase
   *   Text object.
   */
  public static function i(int $number): TextBuilderBase {
    return new Text_Raw((string) $number);
  }

  /**
   * Builds a text object for a html list with <ul>.
   *
   * @param \Ock\Ock\Text\TextInterface[] $parts
   *   List items.
   *
   * @return \Ock\Ock\Text\Text_ListBase
   *   Translatable text object.
   */
  public static function ul(array $parts = []): Text_ListBase {
    return new Text_List($parts, 'ul');
  }

  /**
   * Builds a text object for a html list with <ol>.
   *
   * @param \Ock\Ock\Text\TextInterface[] $parts
   *   List items.
   *
   * @return \Ock\Ock\Text\Text_ListBase
   *   Translatable text object.
   */
  public static function ol(array $parts = []): Text_ListBase {
    return new Text_List($parts, 'ol');
  }

  /**
   * Builds a text object for a html list with <ul> or <ol>.
   *
   * @param \Ock\Ock\Text\TextInterface[] $parts
   *   List items.
   * @param string $tag
   *   One of 'ul' or 'ol'.
   *
   * @return \Ock\Ock\Text\Text_ListBase
   *   Translatable text object.
   */
  protected static function ulOrOl(array $parts, string $tag): Text_ListBase {
    if ($tag !== 'ul' && $tag !== 'ol') {
      throw new \InvalidArgumentException('Invalid list tag name.');
    }
    return new Text_List($parts, $tag);
  }

  /**
   * Gets a non-translatable text object.
   *
   * @param \Ock\Ock\Text\TextInterface[] $parts
   *   List items.
   * @param string $glue
   *   Glue string between the items.
   *
   * @return \Ock\Ock\Text\Text_ListBase
   *   Translatable text object.
   */
  public static function concat(array $parts, string $glue = ''): Text_ListBase {
    return new Text_ListConcat($parts, $glue);
  }

  /**
   * Shows a list of distinct values.
   *
   * @param \Ock\Ock\Text\TextInterface[] $parts
   *   List items.
   * @param string $glue
   *   Glue string between the items.
   *
   * @return \Ock\Ock\Text\Text_ListBase
   *   Translatable text object.
   */
  public static function concatDistinct(array $parts, string $glue = ' | '): Text_ListBase {
    return new Text_ConcatDistinct($parts, $glue);
  }

  /**
   * Validates text objects.
   *
   * @param \Ock\Ock\Text\TextInterface ...$texts
   */
  public static function validate(TextInterface ...$texts): void {}

  /**
   * Validates text objects.
   *
   * @param \Ock\Ock\Text\TextInterface[] $texts
   *   Text objects to validate.
   *   In PHP < 8.0, string keys are not allowed here.
   */
  public static function validateMultiple(array $texts): void {
    self::validate(...array_values($texts));
  }

  /**
   * Validates arrays of text objects.
   *
   * @param \Ock\Ock\Text\TextInterface[][] $textss
   *   Arrays of text objects.
   *   This array can have string keys.
   */
  public static function validateNested(array $textss): void {
    foreach ($textss as $texts) {
      self::validate(...array_values($texts));
    }
  }

}
