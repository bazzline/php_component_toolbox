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

        return array(
            array(
                $haystack,
                'al l',
                false,
                true
            ),
            array(
                $haystack,
                'lalal l',
                false,
                false
            ),
            array(
                $haystack,
                'lalal l',
                true,
                true
            )
        );
    }

    /**
     * @return array
     */
    public function endsWithTestProvider()
    {
        $haystack = 'traLalal lula bula';

        return array(
            array(
                $haystack,
                ' bula',
                false,
                true
            ),
            array(
                $haystack,
                '  bula',
                false,
                false
            ),
            array(
                $haystack,
                'uLa',
                true,
                true
            )
        );
    }

    /**
     * @return array
     */
    public function startsWithTestProvider()
    {
        $haystack = 'traLalal lula bula';

        return array(
            array(
                $haystack,
                'traLalal l',
                false,
                true
            ),
            array(
                $haystack,
                'trala',
                false,
                false
            ),
            array(
                $haystack,
                'trala',
                true,
                true
            )
        );
    }
}