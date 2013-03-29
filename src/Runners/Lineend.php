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
 * Check file for allowed line-end (unix|windows)
 */
class Lineend extends RunnersAbstract
{
    protected $_name = "Check Line Ends";
    protected $_toolName = "cat and wc";
    protected $_toolCheckCommand = "which cat && which wc";
    protected $_fileFilterRegexp = null; //all files should be checked

    function run(array $files)
    {

        //get required config params
        //TODO: check for valid parameters
        $allowedLineEnd = $this->_vcs->getConfig("muhafiz.runners.lineend.allowed", "unix");

        foreach ($files as $file) {
            $cmd = $this->_vcs->catCommand($file);
            $out = Sys::runCommand(
                "echo `" . $cmd . " | cat -e | wc -l`,`" . $cmd . " | cat -e | grep '\^M\$$' | wc -l`"
            );
            list($total, $windows) = explode(",", $out['output'][0]);

            $unix = $total - $windows;

            if ($allowedLineEnd == "unix" && $windows > 0) {
                $this->_onRuleFailed($out, array("file"=>$file, "allowed"=>$allowedLineEnd));
            } elseif ($allowedLineEnd == "windows" && $unix > 0) {
                $this->_onRuleFailed($out, array("file"=>$file, "allowed"=>$allowedLineEnd));
            }
        }
    }


    /**
     * @override
     */
    protected function _onRuleFailed(array $out, $args = null)
    {
        $msg = "'".$args['file']."' doesn't have '".$args['allowed']."' line endings";
        throw new \Muhafiz\Exceptions\RuleFailed($this->_name . " : " . $msg);
    }
}
