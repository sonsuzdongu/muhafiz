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

/**
 * All runners should have 'run()' method for given files array
 */
abstract class RunnersAbstract
{
    /**
     * If any other tool needed for this runner
     * check availilibility of this by executing $_toolCheckCommand
     */
    public final function __construct()
    {
        if ($this->_toolCheckCommand) {
            $cmdOut = Sys::runCommand($this->_toolCheckCommand);
            if ($cmdOut['exitCode'] != 0) {
                $msg = "'" . $this->_toolName . "' is not installed on your system";
                throw new \Muhafiz\Exceptions\ToolNotFound($this->_name . " : " . $msg);
            }
        }
    }

    /**
     * Filter files and call run() of runner
     *
     * @param array $files list of files
     */
    public function init($files)
    {
        $files = $this->_filterFiles($files);
        $this->run($files);
    }



    /**
     * a wrapper which we may use to collect all errors and throw at once
     * @param mixed $out command output
     */
    protected function _onRuleFailed(array $out)
    {
        throw new \Muhafiz\Exceptions\RuleFailed($this->_name . " : " . implode("\n", $out['output']));
    }




    /**
     * filter files matching $_fileFilterRegexp
     *
     * @return string
     */
    private function _filterFiles($files)
    {
        if ($this->_fileFilterRegexp) {
            $files = array_filter($files, array($this, "_filterByRegexp"));
        }
        return $files;
    }


    /**
     * callback function for array_filter
     *
     * @param mixed $input
     */
    private function _filterByRegexp($input)
    {
        return preg_match($this->_fileFilterRegexp, $input);
    }



    /**
     * Runner method which should return boolean or throw an exception
     */ 
    abstract public function run (array $files);
}
