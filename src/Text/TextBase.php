<?php

declare(strict_types=1);

namespace Ock\Ock\Text;

/**
 * Base class with additional convenience methods.
 */
abstract class TextBase implements TextInterface {

  /**
   * @param string $token
   * @param \Ock\Ock\Text\TextInterface $wrapper
   *
   * @return self
   */
  public function wrap(string $token, TextInterface $wrapper): self {
    return new Text_ReplaceOne($wrapper, $token, $this->getThis());
  }

  /**
   * @param string $token
   * @param string $wrapper
   *
   * @return self
   */
  public function wrapT(string $token, string $wrapper): self {
    return $this->wrap($token, Text::t($wrapper));
  }

  /**
   * @param string $token
   * @param string $wrapper
   *
   * @return self
   */
  public function wrapS(string $token, string $wrapper): self {
    return $this->wrap($token, Text::s($wrapper));
  }

  /**
   * @param string $wrapper
   *
   * @return self
   */
  public function wrapSprintf(string $wrapper): self {
    return new Text_SprintfOne($wrapper, $this->getThis());
  }

  /**
   * @return \Ock\Ock\Text\TextInterface
   */
  protected function getThis(): TextInterface {
    return $this;
  }

}
