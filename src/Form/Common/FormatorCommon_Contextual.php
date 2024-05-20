<?php

declare(strict_types=1);

namespace Ock\Ock\Form\Common;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\Attribute\Parameter\Adaptee;
use Ock\Adaptism\Attribute\Parameter\AdapterTargetType;
use Ock\Adaptism\Attribute\Parameter\UniversalAdapter;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\Formula\Contextual\Formula_ContextualInterface;

class FormatorCommon_Contextual {

  /**
   * @template T as \Ock\Ock\Form\Common\FormatorCommonInterface
   *
   * @param \Ock\Ock\Formula\Contextual\Formula_ContextualInterface $formula
   * @param class-string<T> $interface
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return T|null
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   */
  #[Adapter]
  public static function adapt(
    #[Adaptee] Formula_ContextualInterface $formula,
    #[AdapterTargetType] string $interface,
    #[UniversalAdapter] UniversalAdapterInterface $universalAdapter,
  ): ?FormatorCommonInterface {
    if (!\is_a($interface, FormatorCommonInterface::class, true)) {
      // @todo Throw exception?
      return null;
    }
    /** @var class-string<T> $interface */
    return $universalAdapter->adapt($formula->getDecorated(), $interface);
  }

}
