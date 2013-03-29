<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */

// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//      http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS-IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

namespace Muhafiz\Utils;

class Misc
{
    /**
     * Accesses child elements by path notation.
     * @param array $array array
     * @param string $path path
     * @param mixed $defaultValue default value if target does not exist
     * @return mixed target element
     */
    public static function readIniValue(array $array, $path, $defaultValue = null)
    {
        $variable = $array;

        // larukedi: removing the limit parameter of explode function might be useful
        // if the data structure of array is more complex than two-dimension. but
        // it's okay for now since we're dealing with the .ini files.
        foreach (explode('.', $path, 2) as $key) {
            if (!isset($variable[$key])) {
                return $defaultValue;
            }

            $variable = $variable[$key];
        }

        return $variable;
    }
}
