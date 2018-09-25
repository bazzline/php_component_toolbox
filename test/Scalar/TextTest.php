<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-10-10
 */
namespace Test\Net\Bazzline\Component\Toolbox\Scalar;

use Test\Net\Bazzline\Component\Toolbox\AbstractTestCase;

class TextTest extends AbstractTestCase
{
    /**
     * @dataProvider containsTestProvider
     * @param string $haystack
     * @param string $needle
     * @param bool $searchCaseInsensitive
     * @param bool $expectedResult
     */
    public function testContains($haystack, $needle, $searchCaseInsensitive, $expectedResult)
    {
        $text = $this->getNewText();

        $this->assertEquals(
            $expectedResult,
            $text->contains($haystack, $needle, $searchCaseInsensitive)
        );
    }

    /**
     * @dataProvider endsWithTestProvider
     * @param string $haystack
     * @param string $needle
     * @param bool $searchCaseInsensitive
     * @param bool $expectedResult
     */
    public function testEndsWith($haystack, $needle, $searchCaseInsensitive, $expectedResult)
    {
        $text = $this->getNewText();

        $this->assertEquals(
            $expectedResult,
            $text->endsWith($haystack, $needle, $searchCaseInsensitive)
        );
    }

    /**
     * @dataProvider startsWithTestProvider
     * @param string $haystack
     * @param string $needle
     * @param bool $searchCaseInsensitive
     * @param bool $expectedResult
     */
    public function testStartsWith($haystack, $needle, $searchCaseInsensitive, $expectedResult)
    {
        $text = $this->getNewText();

        $this->assertEquals(
            $expectedResult,
            $text->startsWith($haystack, $needle, $searchCaseInsensitive)
        );
    }

    /**
     * @return array
     */
    public function containsTestProvider()
    {
        $haystack = 'traLalal lula bula';

        return [
            [
                $haystack,
                'al l',
                false,
                true
            ],
            [
                $haystack,
                'lalal l',
                false,
                false
            ],
            [
                $haystack,
                'lalal l',
                true,
                true
            ]
        ];
    }

    /**
     * @return array
     */
    public function endsWithTestProvider()
    {
        $haystack = 'traLalal lula bula';

        return [
            [
                $haystack,
                ' bula',
                false,
                true
            ],
            [
                $haystack,
                '  bula',
                false,
                false
            ],
            [
                $haystack,
                'uLa',
                true,
                true
            ]
        ];
    }

    /**
     * @return array
     */
    public function startsWithTestProvider()
    {
        $haystack = 'traLalal lula bula';

        return [
            [
                $haystack,
                'traLalal l',
                false,
                true
            ],
            [
                $haystack,
                'trala',
                false,
                false
            ],
            [
                $haystack,
                'trala',
                true,
                true
            ]
        ];
    }
}
