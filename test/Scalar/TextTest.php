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
    public function testContains(string $haystack, string $needle, bool $searchCaseInsensitive, bool $expectedResult): void
    {
        $text = $this->getNewText();

        self::assertEquals(
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
    public function testEndsWith(string $haystack, string $needle, bool $searchCaseInsensitive, bool $expectedResult): void
    {
        $text = $this->getNewText();

        self::assertEquals(
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
    public function testStartsWith(string $haystack, string $needle, bool $searchCaseInsensitive, bool $expectedResult): void
    {
        $text = $this->getNewText();

        self::assertEquals(
            $expectedResult,
            $text->startsWith($haystack, $needle, $searchCaseInsensitive)
        );
    }

    public function containsTestProvider(): array
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

    public function endsWithTestProvider(): array
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

    public function startsWithTestProvider(): array
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
