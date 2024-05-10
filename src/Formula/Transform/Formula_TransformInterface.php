<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Transform;

use Donquixote\Ock\Core\Formula\FormulaInterface;

interface Formula_TransformInterface {

  /**
   * Unpacks and validates stored configuration.
   *
   * @param mixed $packed_conf
   *   Configuration from storage.
   *
   * @return mixed
   *   Configuration compatible with the decorated formula.
   *
   * @throws \Exception
   *   Stored configuration is invalid.
   */
  public function unpack(mixed $packed_conf): mixed;

  /**
   * Packs configuration for storage.
   *
   * @param mixed $unpacked_conf
   *   Configuration compatible with the decorated formula.
   *
   * @return mixed
   *   Configuration to be stored.
   *
   * @throws \Exception
   *   Unpacked configuration is invalid.
   */
  public function pack(mixed $unpacked_conf): mixed;

  /**
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   */
  public function getDecorated(): FormulaInterface;

}
