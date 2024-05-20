<?php

declare(strict_types=1);

use Ock\Ock\Text\Text;

// Don't create global vars.
return call_user_func(static function () {
  return Text::ul()
    // @todo Filter out html?
    ->add(Text::s('<em>s</em><script></script>'))
    ->add(Text::t('<em>t</em><script></script>'));
});
