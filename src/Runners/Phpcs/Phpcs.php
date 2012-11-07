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


/**
 * Php CodeSniffer adapter to check files using phpcs
 */
class Runners_Phpcs_Phpcs extends Runners_Abstract
{
    function apply(array $files)
    {
        //get required config params
        $standard = Utils_Git::getConfig("muhafiz.runners.phpcs.standard", "PEAR");
        $report = Utils_Git::getConfig("muhafiz.runners.phpcs.report", "emacs");

        foreach ($files as $file) {
            $out = Utils_System::runCommand("phpcs ${file} --standard=${standard} --report=emacs");

            if ($out['exitCode'] != 0) {
                throw new Exceptions_RuleFailed($out['output'][0]);
            }
        }
    }
}
