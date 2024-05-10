<?php

declare(strict_types=1);

use Donquixote\Ock\Text\Text;

return Text::ul()
  ->add(Text::s('First item'))
  ->add(Text::t('Second item'))
  ->addS('Third item')
  ->addT('Fourth item');
