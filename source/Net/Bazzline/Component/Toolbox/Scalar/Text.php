<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-10-10
 */
namespace Net\Bazzline\Component\Toolbox\Scalar;

class Text
{
    /**
     * @param string $haystack
     * @param string $needle
     * @param bool|false $searchCaseInsensitive
     * @return boolean
     */
    public function contains($haystack, $needle, $searchCaseInsensitive = false)
    {
        if (strlen($needle) == 0) {
            $contains = false;
        } else {
            if ($searchCaseInsensitive) {
                $haystack   = strtolower($haystack);
                $needle     = strtolower($needle);
            }

            $contains = !(strpos($haystack, $needle) === false);
        }

        return $contains;
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @param bool|false $searchCaseInsensitive
     * @return bool
     */
    public function endsWith($haystack, $needle, $searchCaseInsensitive = false)
    {
        if ($searchCaseInsensitive) {
            $haystack   = strtolower($haystack);
            $needle     = strtolower($needle);
        }

        return (substr($haystack, -(strlen($needle))) === $needle);
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @param bool|false $searchCaseInsensitive
     * @return bool
     */
    public function startsWith($haystack, $needle, $searchCaseInsensitive = false)
    {
        if ($searchCaseInsensitive) {
            $haystack   = strtolower($haystack);
            $needle     = strtolower($needle);
            $startsWith = (strncmp($haystack, $needle, strlen($needle)) === 0);
        } else {
            $startsWith = (strncmp($haystack, $needle, strlen($needle)) === 0);
        }

        return $startsWith;
    }
}