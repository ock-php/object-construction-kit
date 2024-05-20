<?php

declare(strict_types=1);

namespace Ock\Ock\Tests;

use Ock\Ock\Util\StringUtil;
use PHPUnit\Framework\TestCase;

class StringUtilTest extends TestCase {

  public function testFindRegex(): void {
    self::assertSame(
      '/([A-Z][^A-Z]+)/',
      StringUtil::camelCaseExplodeExampleToRegex('AAA Bc'),
    );
  }

  public function testMethodNameLabel(): void {
    self::assertSame(
      'Hello world',
      StringUtil::methodNameGenerateLabel('helloWorld'),
    );
    self::assertSame(
      'Hello world',
      StringUtil::methodNameGenerateLabel('hello_world'),
    );
    self::assertSame(
      'Aaa bc de ff',
      StringUtil::methodNameGenerateLabel('AAABcDeFF'),
    );
  }

  public function testCamelCaseExplode(): void {
    self::assertSame(
      ['hello', 'world'],
      StringUtil::camelCaseExplode('HelloWorld'),
    );
    self::assertSame(
      'AAA.Bc.De.FF',
      StringUtil::camelCaseExplode(
        'AAABcDeFF',
        false,
        'AA Bc',
        '.',
      ),
    );
  }

}
