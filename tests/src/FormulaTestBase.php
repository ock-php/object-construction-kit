<?php

declare(strict_types=1);

namespace Ock\Ock\Tests;

use PHPUnit\Framework\TestCase;
use function Ock\Helpers\scandir_known;

class FormulaTestBase extends TestCase {

  /**
   * Data provider.
   *
   * @return \Iterator<array{string}>
   *   Parameter combos.
   */
  public function providerTestFormula(): \Iterator {
    $dir = dirname(__DIR__) . '/fixtures/formula';
    $candidates = scandir_known($dir);
    foreach ($candidates as $candidate) {
      if (preg_match('@^(\w+)\.php$@', $candidate, $m)) {
        yield [$m[1]];
      }
    }
  }

  /**
   * Data provider.
   *
   * @return \Iterator<array{string, string}>
   *   Parameter combos.
   */
  public function providerTestFormulaCases(): \Iterator {
    $dir = dirname(__DIR__) . '/fixtures/formula';
    $candidates = scandir_known($dir);
    // Prevent duplicates, but detect orphan files.
    $comboss_map = [];
    foreach ($candidates as $candidate) {
      if (preg_match('@^(\w+)\.(\w+)\.\w+$@', $candidate, $m)) {
        [, $base, $case] = $m;
        $comboss_map[$base][$case] = TRUE;
      }
    }
    foreach ($comboss_map as $base => $cases_map) {
      $base = (string) $base;
      foreach ($cases_map as $case => $_) {
        yield [$base, (string) $case];
      }
    }
  }

  /**
   * Data provider.
   *
   * @return \Iterator<int, array{string, string}>
   *   Argument combos.
   */
  public function providerTestIface(): \Iterator {
    $dir = dirname(__DIR__) . '/fixtures/iface';
    foreach (scandir_known($dir) as $dir_candidate) {
      if ($dir_candidate === '.' || $dir_candidate === '..') {
        continue;
      }
      // Prevent duplicates, but detect orphan files.
      $names_map = [];
      foreach (scandir_known($dir . '/' . $dir_candidate) as $file_candidate) {
        if (preg_match('@^(\w+)\.\w+$@', $file_candidate, $m)) {
          $names_map[$m[1]] = TRUE;
        }
      }
      foreach ($names_map as $name => $_) {
        yield [$dir_candidate, $name];
      }
    }
  }

}
