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

class Pyflakes extends RunnersAbstract
{
    protected $_name = 'Pyflakes';
    protected $_toolName = 'pyflakes';
    protected $_toolCheckCommand = 'which pyflakes';
    protected $_fileFilterRegexp = '/\.py$/';

    function run(array $files)
    {
        foreach ($files as $file) {
            $out = Sys::runCommand(
                sprintf('%s %s', $this->_toolName, $file)
            );
            if ($out['exitCode'] != 0) {
                $this->_onRuleFailed($out);
            }
        }
    }
}
