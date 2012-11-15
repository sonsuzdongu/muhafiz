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

class System
{
    /**
     * Run given command return output and exit code of this
     * @return array
     *
     * TODO: we have to return a transfer object for type safe
     * but there's a problem with adding additional scripts
     * we'll look back later
     */
    public static function runCommand($command)
    {
        exec($command, $output, $exitCode);
        return array("output" => $output, "exitCode" => $exitCode);
    }

    /**
     * unline given files
     *
     * @param array $files list of files
     * @return void
     */
    public static function removeFiles(array $files)
    {
        foreach ($files as $file) {
            unlink($file);
        }
    }

}
