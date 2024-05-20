<?php

declare(strict_types=1);

namespace Ock\Ock\Attribute\Parameter;

use Ock\Ock\Contract\LabelHavingInterface;
use Ock\Ock\Contract\NameHavingInterface;
use Ock\Ock\Text\Text;
use Ock\Ock\Text\TextInterface;

#[\Attribute(\Attribute::TARGET_PARAMETER|\Attribute::TARGET_PROPERTY)]
class OckOption implements NameHavingInterface, LabelHavingInterface {

  /**
   * Constructor.
   *
   * @param string $name
   * @param string $label
   * @param bool $translate
   */
  public function __construct(
    private readonly string $name,
    private readonly string $label,
    private readonly bool $translate = true,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getLabel(): TextInterface {
    return Text::tIf($this->label, $this->translate);
  }

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return $this->name;
  }

}
