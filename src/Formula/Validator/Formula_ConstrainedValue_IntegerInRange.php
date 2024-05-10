<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Validator;

use Donquixote\Helpers\Util\MessageUtil;
use Donquixote\Ock\Formula\Description\Formula_DescriptionInterface;
use Donquixote\Ock\Text\Text;
use Donquixote\Ock\Text\TextInterface;

final class Formula_ConstrainedValue_IntegerInRange implements Formula_ConstrainedValueInterface, Formula_DescriptionInterface {

  /**
   * Constructor.
   *
   * @param int|null $min
   * @param int|null $max
   */
  public function __construct(
    public readonly ?int $min = NULL,
    public readonly ?int $max = NULL,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getDescription(): ?TextInterface {
    if ($this->max === NULL) {
      if ($this->min === NULL) {
        return Text::t('Integer number.');
      }
      if ($this->min === 0) {
        return Text::t('Non-negative integer.');
      }
      if ($this->min === 1) {
        return Text::t('Positive integer.');
      }
      return Text::t('Integer greater or equal to @min')
        ->replace('@min', Text::i($this->min));
    }

    if ($this->min === NULL) {
      return Text::t('Integer up to @max')
        ->replace('@max', Text::i($this->max));
    }

    return Text::t('Integer in range [@min...@max]')
      ->replace('@min', Text::i($this->min))
      ->replace('@max', Text::i($this->max));
  }

  /**
   * @inheritDoc
   */
  public function validate(mixed $conf): \Iterator {
    if (!is_int($conf)) {
      yield Text::t('Expected an integer, found @found.')
        ->replaceS('@found', MessageUtil::formatValue($conf));
      return;
    }

    if ($this->min !== NULL && $conf < $this->min) {
      if (0 === $this->min) {
        yield Text::t('Value must be non-negative.');
      }
      elseif (1 === $this->min) {
        yield Text::t('Value must be positive.');
      }
      else {
        yield Text::t('Value must be greater than or equal to @min.')
          ->replace('@min', Text::i($this->min));
      }
    }

    if ($this->max !== NULL && $conf > $this->max) {
      yield Text::t('Value must be no greater than @max.')
        ->replace('@max', Text::i($this->max));
    }
  }

}
