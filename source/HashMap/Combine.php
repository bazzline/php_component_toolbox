<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-04-26
 */

namespace Net\Bazzline\Component\Toolbox\HashMap;

class Combine
{
    /**
     * @param array $keys
     * @param array $values
     * @return array
     */
    public function __invoke(array $keys, array $values)
    {
        return $this->combine($keys, $values);
    }

    /**
     * @param array $keys
     * @param array $values
     * @return array
     */
    public function combine(array $keys, array $values)
    {
        list($areEmpty, $areSameInSize, $areMoreKeys) = $this->createConditions($keys, $values);

        if ($areEmpty) {
            $combined = array();
        } else if ($areSameInSize) {
            $combined = array_combine($keys, $values);
        } else {
            if ($areMoreKeys) {
                $combined = $this->combineWithMoreKeys($keys, $values);
            } else {
                $combined = $this->combineWithMoreValues($keys, $values);
            }
        }

        return $combined;
    }

    /**
     * @param array $keys
     * @param array $values
     * @return array
     */
    private function createConditions(array $keys, array $values)
    {
        $sizeOfKeys     = count($keys);
        $sizeOfValues   = count($values);

        $areEmpty       = (($sizeOfKeys === 0) && ($sizeOfValues === 0));
        $areSameInSize  = ($sizeOfKeys === $sizeOfValues);
        $areMoreKeys    = ($sizeOfKeys > $sizeOfValues);

        return array($areEmpty, $areSameInSize, $areMoreKeys);
    }

    /**
     * @param array $keys
     * @param array $values
     * @return array
     */
    private function combineWithMoreKeys(array $keys, array $values)
    {
        $combined = array();

        foreach (array_values($keys) as $index => $key) {
            if (isset($values[$index])) {
                $combined[$key] = $values[$index];
            }
        }

        return $combined;
    }

    /**
     * @param array $keys
     * @param array $values
     * @return array
     */
    private function combineWithMoreValues(array $keys, array $values)
    {
        $combined = array();

        foreach (array_values($values) as $index => $value) {
            if (isset($keys[$index])) {
                $combined[$keys[$index]] = $value;
            } else {
                $combined[] = $value;
            }
        }

        return $combined;
    }
}