<?php

declare(strict_types=1);

namespace Ock\Ock\Text;

class TextBuilder {

  /**
   * @var \Ock\Ock\Text\TextInterface[]
   */
  private array $replacements = [];

  /**
   * @var callable[]
   *   Signature: (TextInterface): TextInterface.
   */
  private array $wrapperOps = [];

  /**
   * @param string $token
   * @param \Ock\Ock\Text\TextInterface $replacement
   *
   * @return $this
   */
  public function replace(string $token, TextInterface $replacement): self {
    $this->replacements[$token] = $replacement;
    return $this;
  }

  /**
   * @param string $token
   * @param string $replacement
   *
   * @return $this
   */
  public function replaceS(string $token, string $replacement): self {
    $this->replacements[$token] = Text::s($replacement);
    return $this;
  }

  /**
   * @param string $token
   * @param string $replacement
   *
   * @return $this
   */
  public function replaceT(string $token, string $replacement): self {
    $this->replacements[$token] = Text::t($replacement);
    return $this;
  }

  /**
   * @param string $token
   * @param \Ock\Ock\Text\TextInterface $wrapper
   *
   * @return $this
   */
  public function wrap(string $token, TextInterface $wrapper): self {
    $this->wrapperOps[] = static function (TextInterface $text) use ($token, $wrapper) {
      return new Text_ReplaceOne($wrapper, $token, $text);
    };
    return $this;
  }

  /**
   * @param string $wrapper
   *
   * @return $this
   */
  public function wrapSprintf(string $wrapper): self {
    $this->wrapperOps[] = static function (TextInterface $text) use ($wrapper) {
      return new Text_SprintfOne($wrapper, $text);
    };
    return $this;
  }

  /**
   * @param string $source
   *
   * @return \Ock\Ock\Text\TextInterface
   */
  public function s(string $source): TextInterface {
    return $this->build(new Text_Raw($source));
  }

  /**
   * @param string $source
   *
   * @return \Ock\Ock\Text\TextInterface
   */
  public function t(string $source): TextInterface {
    return $this->build(new Text_Translatable($source));
  }

  /**
   * @param \Ock\Ock\Text\TextInterface $text
   *
   * @return \Ock\Ock\Text\TextInterface
   */
  public function build(TextInterface $text): TextInterface {
    if ($this->replacements) {
      $text = new Text_Replacements($text, $this->replacements);
    }
    foreach ($this->wrapperOps as $op) {
      $text = $op($text);
    }
    return $text;
  }

}
