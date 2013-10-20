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

class Pep8 extends RunnersAbstract
{
    protected $_name = 'Pep8';
    protected $_toolName = 'pep8';
    protected $_toolCheckCommand = 'which pep8';
    protected $_fileFilterRegexp = '/\.py$/';

    private $_options = array(
        'muhafiz.runners.pep8.repeat'          => array('--repeat', true),
        'muhafiz.runners.pep8.ignore'          => array('--ignore', false),
        'muhafiz.runners.pep8.select'          => array('--select', false),
        'muhafiz.runners.pep8.show-source'     => array('--show-source', true),
        'muhafiz.runners.pep8.show-pep8'       => array('--show-pep8', false),
        'muhafiz.runners.pep8.show-statistics' => array('--statistics', true)
        );

    /**
     * returns tool option name by muhafiz configuration key.
     * 
     * @param string $key
     * @return string
     */
    private function _getOptionName($key)
    {
        if (!isset($this->_options[$key])) {
            throw new Exception("Unknown configuration key: ${$key}");
        }
        return $this->_options[$key][0];
    }

    /**
     * returns default value for the specified 
     * muhafiz configuration key
     */
    private function _getOptionDefault($key)
    {
        if (!isset($this->_options[$key])) {
            throw new Exception("Unknown configuration key: ${$key}");
        }
        return $this->_options[$key][1];    
    }

    /**
     * returns arguments that will be used with tool. 
     * 
     * @return string
     */
    private function _getArguments()
    {
        $keys = array_keys($this->_options);
        $arguments = '';
        foreach ($keys as $key) {
            $default = $this->_getOptionDefault($key);
            $config = $this->_vcs->getConfig($key, $default);
            if (!filter_var($config, FILTER_VALIDATE_BOOLEAN)) {
                continue;
            }
            $arguments .= sprintf(
                ' %s %s', 
                $this->_getOptionName($key), 
                filter_var($config, FILTER_VALIDATE_BOOLEAN) === true ? 
                '' : $config 
            );
        }
        return trim($arguments);
    }

    function run(array $files)
    {
        foreach ($files as $file) {
            $out = Sys::runCommand(
                sprintf(
                    '%s %s %s', $this->_toolName, $this->_getArguments(), $file
                )
            );
            if ($out['exitCode'] != 0) {
                $this->_onRuleFailed($out);
            }
        }
    }
}

