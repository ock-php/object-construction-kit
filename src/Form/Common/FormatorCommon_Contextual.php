<?php

declare(strict_types=1);

namespace Donquixote\Ock\Form\Common;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Adaptism\Attribute\Parameter\Adaptee;
use Donquixote\Adaptism\Attribute\Parameter\AdapterTargetType;
use Donquixote\Adaptism\Attribute\Parameter\UniversalAdapter;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\Formula\Contextual\Formula_ContextualInterface;

class FormatorCommon_Contextual {

  /**
   * @template T as \Donquixote\Ock\Form\Common\FormatorCommonInterface
   *
   * @param \Donquixote\Ock\Formula\Contextual\Formula_ContextualInterface $formula
   * @param class-string<T> $interface
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return T|null
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
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
