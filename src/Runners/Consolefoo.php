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


namespace Muhafiz\Runners;
use Muhafiz\Utils\System as Sys;
use Muhafiz\Runners\RunnersAbstract as RunnersAbstract;

/**
 * Check if js files contains console.*() statements
 */
class Consolefoo extends RunnersAbstract
{
    protected $_name = "console.foo()";
    protected $_toolName = "grep";
    protected $_toolCheckCommand = "which grep";
    protected $_fileFilterRegexp = "/\.js$/"; //php and phtml files should be checked

    function run(array $files)
    {
        foreach ($files as $file) {
            //check if files have console.*() statements
            //but dont check files which are commented with //
            $out = Sys::runCommand(
                $this->_vcs->catCommand($file) .
                " | grep -vE '^\s*\/\/' | grep -iqE 'console\.[a-zA-Z]{1,20}\s*\(' 2>&1"
            );

            if ($out['exitCode'] == 0) {
                $out['output'][] = "'${file}' file contains console.*() statement";
                $this->_onRuleFailed($out);
            }
        }
    }
}
