<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Textfield;

use Donquixote\Ock\Text\Text;
use Donquixote\Ock\Text\TextInterface;

class Formula_Textfield_IntegerInRange extends Formula_Textfield_IntegerBase {

  /**
   * Constructor.
   *
   * @param int|null $min
   * @param int|null $max
   */
  public function __construct(
    private readonly ?int $min = NULL,
    private readonly ?int $max = NULL,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getDescription(): ?TextInterface {

    if (NULL === $this->max) {
      if (NULL === $this->min) {
        return Text::t('Integer number.');
      }

      if (0 === $this->min) {
        return Text::t('Non-negative integer.');
      }

      if (1 === $this->min) {
        return Text::t('Positive integer.');
      }

      return Text::t('Integer greater or equal to @min')
        ->replace('@min', Text::i($this->min));
    }

    if (NULL === $this->min) {
      return Text::t('Integer up to @max')
        ->replace('@max', Text::i($this->max));
    }

    return Text::t('Integer in range [@min...@max]')
      ->replace('@min', Text::i($this->min))
      ->replace('@max', Text::i($this->max));
  }

  /**
   * @param int $number
   *
   * @return \Donquixote\Ock\Text\TextInterface[]
   */
  protected function numberGetValidationErrors(int $number): array {

    $errors = [];

    if ($this->min !== NULL && $number < $this->min) {
      if (0 === $this->min) {
        $errors[] = Text::t('Value must be non-negative.');
      }
      elseif (1 === $this->min) {
        $errors[] = Text::t('Value must be positive.');
      }
      else {
        $errors[] = Text::t('Value must be greater than or equal to @min.')
          ->replace('@min', Text::i($this->min));
      }
    }

    /**
     * Suppress false positive inspection.
     *
     * See https://github.com/kalessil/phpinspectionsea/issues/1707#issuecomment-917009487.
     */
    if ($this->max !== NULL && $number > $this->max) {
      $errors[] = Text::t('Value must be no greater than @max.')
        ->replace('@max', Text::i($this->max));
    }

    return $errors;
  }

}
