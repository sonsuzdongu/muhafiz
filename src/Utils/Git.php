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
use Muhafiz\Utils\System as Sys;

/**
 * Git helper which supplies a high-level API for git command
 */
class Git
{
    /**
     * return list of staged files
     * @return array
     */
    public static function getStagedFiles()
    {
        return Sys::runCommand("git diff --cached --name-only --diff-filter=ACM");
    }


    /**
     * return list of new added files
     * @return array
     */
    public static function getNewFiles()
    {
        return static::_removeFileFlag(Sys::runCommand("git status --short | grep ^A"));
    }


    /**
     * read config from given key
     * @param string $key key to read
     * @param string|null $defaultValue default value for key, if value not set
     * @return string
     */
    public static function getConfig($key, $defaultValue = null)
    {
        $result = Sys::runCommand("git config ${key}");
        return isset($result['output'][0]) ? $result['output'][0] : $defaultValue;
    }


    /**
     * Set git config by key/value
     * @param string $key key to set
     * @param string $value value for key
     * @return boolean
     */
    public static function setConfig($key, $value)
    {
        $result = Sys::runCommand("git config ${key} ${value}");
        return $result['exitCode'] == 0;
    }


    /**
     * Removes any file flag like A, M, ?? from file
     * @param array $result
     * @return array
     */
    private static function _removeFileFlag($result)
    {
        $result['output'] = array_map(
            function ($item) {
                return trim(preg_replace("/^.*? /", "", $item));
            }, $result['output']
        );

        return $result;
    }
}
