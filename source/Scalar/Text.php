<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-10-10
 */
namespace Net\Bazzline\Component\Toolbox\Scalar;

class Text
{
    public function contains(
        string $haystack,
        string $needle,
        bool $searchCaseInsensitive = false
    ): bool {
        if (strlen($needle) == 0) {
            $contains = false;
        } else {
            if ($searchCaseInsensitive) {
                $haystack   = strtolower($haystack);
                $needle     = strtolower($needle);
            }

            $contains = str_contains($haystack, $needle);
        }

        return $contains;
    }

    public function endsWith(
        string $haystack,
        string $needle,
        bool $searchCaseInsensitive = false
    ): bool {
        if ($searchCaseInsensitive) {
            $haystack   = strtolower($haystack);
            $needle     = strtolower($needle);
        }

        return (
            substr(
                $haystack,
                -(
                    strlen($needle)
                )
            ) === $needle
        );
    }

    public function hasTheLengthOf(
        string $string,
        int $expectedLength
    ): bool {
        $length = strlen($string);

        return ($length == $expectedLength);
    }

    public function isLongerThan(
        string $string,
        int $expectedLength
    ): bool {
        $length = strlen($string);

        return ($length > $expectedLength);
    }

    public function isShorterThan(
        string $string,
        int $expectedLength
    ): bool {
        $length = strlen($string);

        return ($length > $expectedLength);
    }


    /**
     * @param string $haystack
     * @param string $needle
     * @param bool|false $searchCaseInsensitive
     * @return bool
     */
    public function startsWith(
        string $haystack,
        string $needle,
        bool $searchCaseInsensitive = false
    ): bool {
        if ($searchCaseInsensitive) {
            $haystack   = strtolower($haystack);
            $needle     = strtolower($needle);
        }

        return (
            strncmp(
                $haystack,
                $needle,
                strlen($needle)
            ) === 0
        );
    }
}
