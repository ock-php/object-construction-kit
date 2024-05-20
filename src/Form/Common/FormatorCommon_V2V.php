<?php

declare(strict_types=1);

namespace Ock\Ock\Form\Common;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\Attribute\Parameter\Adaptee;
use Ock\Adaptism\Attribute\Parameter\AdapterTargetType;
use Ock\Adaptism\Attribute\Parameter\UniversalAdapter;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\FormulaBase\Formula_ConfPassthruInterface;

class FormatorCommon_V2V {

  /**
   * @template T as \Ock\Ock\Form\Common\FormatorCommonInterface
   *
   * @param \Ock\Ock\FormulaBase\Formula_ConfPassthruInterface $formula
   * @param class-string<T> $interface
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return T|null
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   */
  #[Adapter]
  public static function create(
    #[Adaptee] Formula_ConfPassthruInterface $formula,
    #[AdapterTargetType] string $interface,
    #[UniversalAdapter] UniversalAdapterInterface $universalAdapter,
  ): ?FormatorCommonInterface {

    if (!is_a($interface, FormatorCommonInterface::class, TRUE)) {
      return NULL;
    }

    /** @var class-string<T> $interface */
    return $universalAdapter->adapt($formula->getDecorated(), $interface);
  }

}
