<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-12-15
 */

namespace Test\Net\Bazzline\Component\Toolbox\HashMap;

use Test\Net\Bazzline\Component\Toolbox\AbstractTestCase;

class MergeTest extends AbstractTestCase
{
    /**
     * @return array
     */
    public function mergeArraysTestCaseProvider()
    {
        return array(
            'merge-integer-and-string-keys' => array(
                array(
                    'foo',
                    3     => 'bar',
                    'baz' => 'baz',
                    4     => array(
                        'a',
                        1 => 'b',
                        'c',
                    ),
                ),
                array(
                    'baz',
                    4 => array(
                        'd' => 'd',
                    ),
                ),
                true,
                array(
                    0     => 'foo',
                    3     => 'bar',
                    'baz' => 'baz',
                    4     => array(
                        'a',
                        1 => 'b',
                        'c',
                    ),
                    5     => 'baz',
                    6     => array(
                        'd' => 'd',
                    )
                )
            ),
            'merge-integer-and-string-keys-preserve-numeric' => array(
                array(
                    'foo',
                    3     => 'bar',
                    'baz' => 'baz',
                    4     => array(
                        'a',
                        1 => 'b',
                        'c',
                    ),
                ),
                array(
                    'baz',
                    4 => array(
                        'd' => 'd',
                    ),
                ),
                false,
                array(
                    0     => 'baz',
                    3     => 'bar',
                    'baz' => 'baz',
                    4 => array(
                        'a',
                        1 => 'b',
                        'c',
                        'd' => 'd',
                    ),
                )
            ),
            'merge-arrays-recursively' => array(
                array(
                    'foo' => array(
                        'baz'
                    )
                ),
                array(
                    'foo' => array(
                        'baz'
                    )
                ),
                true,
                array(
                    'foo' => array(
                        0 => 'baz',
                        1 => 'baz'
                    )
                )
            ),
            'replace-string-keys' => array(
                array(
                    'foo' => 'bar',
                    'bar' => array()
                ),
                array(
                    'foo' => 'baz',
                    'bar' => 'bat'
                ),
                true,
                array(
                    'foo' => 'baz',
                    'bar' => 'bat'
                )
            ),
            'merge-with-null' => array(
                array(
                    'foo' => null,
                    null  => 'rod',
                    'cat' => 'bar',
                    'god' => 'rad'
                ),
                array(
                    'foo' => 'baz',
                    null  => 'zad',
                    'god' => null
                ),
                true,
                array(
                    'foo' => 'baz',
                    null  => 'zad',
                    'cat' => 'bar',
                    'god' => null
                )
            )
        );
    }


    /**
     * @dataProvider mergeArraysTestCaseProvider
     *
     * @param array $arrayToMergeInto
     * @param array $arrayToMergeFrom
     * @param bool $doNotPreserveNumericKeys
     * @param array $expectedMergeResult
     */
    public function testMergeAsInvokable(array $arrayToMergeInto, array $arrayToMergeFrom, $doNotPreserveNumericKeys, array $expectedMergeResult)
    {
        $merger =  $this->getHashMapMerge();

        $this->assertEquals($expectedMergeResult, $merger($arrayToMergeInto, $arrayToMergeFrom, $doNotPreserveNumericKeys));
    }
}
