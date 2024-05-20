<?php

declare(strict_types=1);

namespace Ock\Ock\Generator;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Helpers\Util\MessageUtil;
use Ock\Ock\Exception\GeneratorException_IncompatibleConfiguration;
use Ock\Ock\Formula\Sequence\Formula_SequenceInterface;
use Ock\Ock\Formula\SequenceVal\Formula_SequenceValInterface;
use Ock\Ock\V2V\Sequence\V2V_Sequence_Trivial;
use Ock\Ock\V2V\Sequence\V2V_SequenceInterface;

class Generator_Sequence implements GeneratorInterface {

  /**
   * @param \Ock\Ock\Formula\Sequence\Formula_SequenceInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return self|null
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   */
  #[Adapter]
  public static function createFromSequenceFormula(Formula_SequenceInterface $formula, UniversalAdapterInterface $universalAdapter): ?Generator_Sequence {
    return self::create($formula, new V2V_Sequence_Trivial(), $universalAdapter);
  }

  /**
   * @param \Ock\Ock\Formula\SequenceVal\Formula_SequenceValInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return self|null
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   */
  #[Adapter]
  public static function createFromSequenceValFormula(Formula_SequenceValInterface $formula, UniversalAdapterInterface $universalAdapter): ?Generator_Sequence {
    return self::create($formula->getDecorated(), $formula->getV2V(), $universalAdapter);
  }

  /**
   * @param \Ock\Ock\Formula\Sequence\Formula_SequenceInterface $formula
   * @param \Ock\Ock\V2V\Sequence\V2V_SequenceInterface $v2v
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return self
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   */
  private static function create(
    Formula_SequenceInterface $formula,
    V2V_SequenceInterface $v2v,
    UniversalAdapterInterface $universalAdapter,
  ): self {
    return new self(
      Generator::fromFormula(
        $formula->getItemFormula(),
        $universalAdapter,
      ),
      $v2v,
    );
  }

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Generator\GeneratorInterface $itemGenerator
   * @param \Ock\Ock\V2V\Sequence\V2V_SequenceInterface $v2v
   */
  protected function __construct(
    private readonly GeneratorInterface $itemGenerator,
    private readonly V2V_SequenceInterface $v2v,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function confGetPhp(mixed $conf): string {

    if (NULL === $conf) {
      $conf = [];
    }
    elseif (!\is_array($conf)) {
      throw new GeneratorException_IncompatibleConfiguration(
        sprintf(
          'Expected an array or NULL, but found %s.',
          MessageUtil::formatValue($conf)));
    }
    elseif ($conf) {
      $keys = array_keys($conf);
      if ($keys !== array_keys($keys)) {
        throw new GeneratorException_IncompatibleConfiguration(
          sprintf(
            'Expected an array with purely sequential keys, found %s.',
            MessageUtil::formatValue($conf)));
      }
    }

    $phpStatements = [];
    foreach ($conf as $itemConf) {
      $phpStatements[] = $this->itemGenerator->confGetPhp($itemConf);
    }

    return $this->v2v->itemsPhpGetPhp($phpStatements);
  }

}
