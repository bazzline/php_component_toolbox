<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-04-26
 */

namespace Net\Bazzline\Component\Toolbox\HashMap;

class Combine
{
    public function __invoke(
        array $keys,
        array $values
    ): array {
        return $this->combine($keys, $values);
    }

    public function combine(
        array $keys,
        array $values
    ): array {
        list($areEmpty, $areSameInSize, $areMoreKeys) = $this->createConditions($keys, $values);

        if ($areEmpty) {
            $combined = [];
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

    private function createConditions(
        array $keys,
        array $values
    ): array {
        $sizeOfKeys     = count($keys);
        $sizeOfValues   = count($values);

        $areEmpty       = (($sizeOfKeys === 0) && ($sizeOfValues === 0));
        $areSameInSize  = ($sizeOfKeys === $sizeOfValues);
        $areMoreKeys    = ($sizeOfKeys > $sizeOfValues);

        return [
            $areEmpty,
            $areSameInSize,
            $areMoreKeys
        ];
    }

    private function combineWithMoreKeys(
        array $keys,
        array $values
    ): array {
        $combined = [];

        foreach (array_values($keys) as $index => $key) {
            if (isset($values[$index])) {
                $combined[$key] = $values[$index];
            }
        }

        return $combined;
    }

    private function combineWithMoreValues(
        array $keys,
        array $values
    ): array {
        $combined = [];

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
