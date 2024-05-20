<?php

declare(strict_types=1);

namespace Ock\Ock\Generator;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\Attribute\Parameter\Adaptee;
use Ock\Ock\Exception\FormulaException;
use Ock\Ock\Exception\GeneratorException;
use Ock\Ock\Exception\GeneratorException_IncompatibleConfiguration;
use Ock\Ock\Formula\Id\Formula_IdInterface;
use Ock\Ock\Formula\IdVal\Formula_IdValInterface;
use Ock\Ock\Util\ConfUtil;
use Ock\Ock\V2V\Id\V2V_Id_Trivial;
use Ock\Ock\V2V\Id\V2V_IdInterface;

class
Generator_Id implements GeneratorInterface {

  /**
   * @param \Ock\Ock\Formula\Id\Formula_IdInterface $formula
   *
   * @return self
   */
  #[Adapter]
  public static function createFromIdFormula(
    #[Adaptee] Formula_IdInterface $formula,
  ): self {
    return new self($formula, new V2V_Id_Trivial());
  }

  /**
   * @param \Ock\Ock\Formula\IdVal\Formula_IdValInterface $formula
   *
   * @return self
   */
  public static function createFromIdValFormula(Formula_IdValInterface $formula): self {
    return new self($formula->getDecorated(), $formula->getV2V());
  }

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\Id\Formula_IdInterface $formula
   * @param \Ock\Ock\V2V\Id\V2V_IdInterface $v2v
   */
  public function __construct(
    private readonly Formula_IdInterface $formula,
    private readonly V2V_IdInterface $v2v,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function confGetPhp(mixed $conf): string {
    if (NULL === $id = ConfUtil::confGetId($conf)) {
      throw new GeneratorException_IncompatibleConfiguration(
        'Required id empty for id formula.',
      );
    }
    try {
      if (!$this->formula->idIsKnown($id)) {
        throw new GeneratorException_IncompatibleConfiguration(
          "Unknown id '$id' for id formula."
        );
      }
    }
    catch (FormulaException $e) {
      throw new GeneratorException($e->getMessage(), 0, $e);
    }
    return $this->v2v->idGetPhp($id);
  }

}
