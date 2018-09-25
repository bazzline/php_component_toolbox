<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-04-26
 */

namespace Test\Net\Bazzline\Component\Toolbox\HashMap;

use Test\Net\Bazzline\Component\Toolbox\AbstractTestCase;

class CombineTest extends AbstractTestCase
{
    /**
     * @return array
     */
    public function combineTestCaseProvider()
    {
        return [
            'empty keys and values' => [
                [],
                [],
                []
            ],
            'empty keys and not empty values' => [
                [],
                ['foo', 'bar'],
                ['foo', 'bar']
            ],
            'not empty keys and empty values' => [
                ['foo', 'bar'],
                [],
                []
            ],
            'keys and values, same in size' => [
                ['baz', 'foobar'],
                ['foo', 'bar'],
                ['baz' => 'foo', 'foobar' => 'bar']
            ],
            'smaller sized keys and values' => [
                ['baz', 'foobar'],
                ['foo', 'bar', 'barfoo'],
                ['baz' => 'foo', 'foobar' => 'bar', 'barfoo']
            ],
            'keys and smaller sized values' => [
                ['baz', 'foobar', 'barfoo'],
                ['foo', 'bar'],
                ['baz' => 'foo', 'foobar' => 'bar']
            ]
        ];
    }

    /**
     * @dataProvider combineTestCaseProvider
     * @param array $keys
     * @param array $values
     * @param array $expectedResult
     */
    public function testCombine(
        array $keys,
        array $values,
        array $expectedResult
    ) {
        $combine = $this->getHashMapCombine();

        self::assertEquals($expectedResult, $combine($keys, $values));
    }
}
