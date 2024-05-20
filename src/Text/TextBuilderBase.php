<?php

declare(strict_types=1);

namespace Ock\Ock\Text;

/**
 * Base class with additional convenience methods.
 */
abstract class TextBuilderBase extends TextBase {

  /**
   * @param string $token
   * @param \Ock\Ock\Text\TextInterface $replacement
   *
   * @return self
   */
  public function replace(string $token, TextInterface $replacement): self {
    return new Text_Replacements($this, [$token => $replacement]);
  }

  /**
   * @param string $token
   * @param string $replacement
   *
   * @return self
   */
  public function replaceT(string $token, string $replacement): self {
    return $this->replace($token, Text::t($replacement));
  }

  /**
   * @param string $token
   * @param string $replacement
   *
   * @return self
   */
  public function replaceS(string $token, string $replacement): self {
    return $this->replace($token, Text::s($replacement));
  }

}
