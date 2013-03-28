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
 * Check file for Byte Order Mark
 */
class Bom extends RunnersAbstract
{
    protected $_name = "ByteOrderMark";
    protected $_toolName = "cat";
    protected $_toolCheckCommand = "which cat && cat --version";
    protected $_fileFilterRegexp = null; //all files should be checked

    function run(array $files)
    {
        foreach ($files as $file) {
            //cat file with --show-nonprinting option 
            //and see if it contains BOM
            $out = Sys::runCommand($this->_vcs->catCommand($file) . " | cat --show-nonprinting | grep -iq '^M-oM-;M-?'");

            if ($out['exitCode'] == 0) { // it means we have BOM in this file
                $this->_onRuleFailed($out);
            }
        }
    }

    /**
     * @override
     */
    protected function _onRuleFailed(array $out)
    {
        throw new \Muhafiz\Exceptions\RuleFailed($this->_name . " : This file contains BOM");
    }
}
