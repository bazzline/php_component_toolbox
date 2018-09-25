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
        return [
            'merge-integer-and-string-keys' => [
                [
                    'foo',
                    3     => 'bar',
                    'baz' => 'baz',
                    4     => [
                        'a',
                        1 => 'b',
                        'c'
                    ]
                ],
                [
                    'baz',
                    4 => [
                        'd' => 'd'
                    ]
                ],
                true,
                [
                    0     => 'foo',
                    3     => 'bar',
                    'baz' => 'baz',
                    4     => [
                        'a',
                        1 => 'b',
                        'c'
                    ],
                    5     => 'baz',
                    6     => [
                        'd' => 'd'
                    ]
                ]
            ],
            'merge-integer-and-string-keys-preserve-numeric' => [
                [
                    'foo',
                    3     => 'bar',
                    'baz' => 'baz',
                    4     => [
                        'a',
                        1 => 'b',
                        'c'
                    ]
                ],
                [
                    'baz',
                    4 => [
                        'd' => 'd'
                    ]
                ],
                false,
                [
                    0     => 'baz',
                    3     => 'bar',
                    'baz' => 'baz',
                    4 => [
                        'a',
                        1 => 'b',
                        'c',
                        'd' => 'd',
                    ],
                ]
            ],
            'merge-arrays-recursively' => [
                [
                    'foo' => [
                        'baz'
                    ]
                ],
                [
                    'foo' => [
                        'baz'
                    ]
                ],
                true,
                [
                    'foo' => [
                        0 => 'baz',
                        1 => 'baz'
                    ]
                ]
            ],
            'replace-string-keys' => [
                [
                    'foo' => 'bar',
                    'bar' => []
                ],
                [
                    'foo' => 'baz',
                    'bar' => 'bat'
                ],
                true,
                [
                    'foo' => 'baz',
                    'bar' => 'bat'
                ]
            ],
            'merge-with-null' => [
                [
                    'foo' => null,
                    null  => 'rod',
                    'cat' => 'bar',
                    'god' => 'rad'
                ],
                [
                    'foo' => 'baz',
                    null  => 'zad',
                    'god' => null
                ],
                true,
                [
                    'foo' => 'baz',
                    null  => 'zad',
                    'cat' => 'bar',
                    'god' => null
                ]
            ]
        ];
    }


    /**
     * @dataProvider mergeArraysTestCaseProvider
     *
     * @param array $arrayToMergeInto
     * @param array $arrayToMergeFrom
     * @param bool $doNotPreserveNumericKeys
     * @param array $expectedMergeResult
     */
    public function testMergeAsInvokable(
        array $arrayToMergeInto,
        array $arrayToMergeFrom,
        bool $doNotPreserveNumericKeys,
        array $expectedMergeResult
    ) {
        $merger =  $this->getHashMapMerge();

        self::assertEquals(
            $expectedMergeResult,
            $merger(
                $arrayToMergeInto,
                $arrayToMergeFrom,
                $doNotPreserveNumericKeys
            )
        );
    }
}
