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
        return array(
            'empty keys and values' => array(
                array(),
                array(),
                array()
            ),
            'empty keys and not empty values' => array(
                array(),
                array('foo', 'bar'),
                array('foo', 'bar')
            ),
            'not empty keys and empty values' => array(
                array('foo', 'bar'),
                array(),
                array()
            ),
            'keys and values, same in size' => array(
                array('baz', 'foobar'),
                array('foo', 'bar'),
                array('baz' => 'foo', 'foobar' => 'bar')
            ),
            'smaller sized keys and values' => array(
                array('baz', 'foobar'),
                array('foo', 'bar', 'barfoo'),
                array('baz' => 'foo', 'foobar' => 'bar', 'barfoo')
            ),
            'keys and smaller sized values' => array(
                array('baz', 'foobar', 'barfoo'),
                array('foo', 'bar'),
                array('baz' => 'foo', 'foobar' => 'bar')
            )
        );
    }

    /**
     * @dataProvider combineTestCaseProvider
     * @param array $keys
     * @param array $values
     * @param array $expectedResult
     */
    public function testCombine(array $keys, array $values, array $expectedResult)
    {
        $combine = $this->getHashMapCombine();

        $this->assertEquals($expectedResult, $combine($keys, $values));
    }
}