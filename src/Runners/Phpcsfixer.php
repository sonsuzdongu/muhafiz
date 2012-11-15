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
//@link https://github.com/fabpot/PHP-CS-Fixer

namespace Muhafiz\Runners;
use Muhafiz\Utils\System as Sys;
use Muhafiz\Utils\Git as Git;
use Muhafiz\Runners\RunnersAbstract as RunnersAbstract;


/**
 * PHP Coding Standards Fixer adapter to check files using php-cs-fixer
 */
class Phpcsfixer extends RunnersAbstract
{
    protected $_name = "PHP Coding Standards Fixer";
    protected $_toolName = "php-cs-fixer";
    protected $_toolCheckCommand = "which php-cs-fixer && php-cs-fixer --version | grep -iq 'PHP CS Fixer'";
    protected $_fileFilterRegexp = "/\.ph(p|tml)$/"; //php and phtml files should be checked

    public function run(array $files)
    {
        //get required config params
        $standard = Git::getConfig("muhafiz.runners.php-cs-fixer.standard", "psr2");        

        foreach ($files as $file) {
            $out = Sys::runCommand("php-cs-fixer fix --dry-run --level=${standard} ${file}");

            if (count($out['output']) > 0) {
                $this->_onRuleFailed($out);
            }
        }
    }
}
