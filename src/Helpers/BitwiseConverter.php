<?php

namespace Internetcode\LaravelUserSettings\Helpers;

class BitwiseConverter {

    /**
     * arrayToBitwiseList function.
     * This method will calculate the exact bit we should give to a specific settings field.
     * @NOTE: This list is ordered, moving settings will result in invalid settings.
     * @TODO: Make this list unsorted. (ie: use a seperate order value and not the index)
     *
     * @param array $array
     *
     * @return array
     */
    public static function arrayToBitwiseList(array $array)
    {
        $count = 1;
        $bitwiseList = [];
        foreach ($array as $field) {
            $bitwiseList[$field] = 1 << $count;
            $count++;
        }
        return $bitwiseList;
    }

}