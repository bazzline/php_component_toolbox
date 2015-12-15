<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-12-15
 */

namespace Net\Bazzline\Component\Toolbox\HashMap;

class Merge
{
    /**
     * @param array $arrayToMergeInto
     * @param array $arrayToMergeFrom
     * @param bool $doNotPreserveNumericKeys
     * @return array
     */
    public function __invoke(array $arrayToMergeInto, array $arrayToMergeFrom, $doNotPreserveNumericKeys = true)
    {
        return $this->merge($arrayToMergeInto, $arrayToMergeFrom, $doNotPreserveNumericKeys);
    }

    /**
     * @param array $arrayToMergeInto
     * @param array $arrayToMergeFrom
     * @param bool $doNotPreserveNumericKeys
     * @return array
     * @see https://github.com/zendframework/zend-stdlib/blob/master/src/ArrayUtils.php static method merge
     */
    public function merge(array $arrayToMergeInto, array $arrayToMergeFrom, $doNotPreserveNumericKeys = true)
    {
        foreach ($arrayToMergeFrom as $key => $value) {
            $keyExistsInSource = (isset($arrayToMergeInto[$key]) || array_key_exists($key, $arrayToMergeInto));

            if ($keyExistsInSource) {
                $appendToSource = ($doNotPreserveNumericKeys && is_int($key));

                if ($appendToSource) {
                    $arrayToMergeInto[] = $value;
                } else {
                    $mergeRecursively = (is_array($value) && is_array($arrayToMergeInto[$key]));

                    if ($mergeRecursively) {
                        $arrayToMergeInto[$key] = $this->merge($arrayToMergeInto[$key], $value, $doNotPreserveNumericKeys);
                    } else {
                        $arrayToMergeInto[$key] = $value;
                    }
                }
            } else {
                $arrayToMergeInto[$key] = $value;
            }
        }

        return $arrayToMergeInto;
    }
}
