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
 * Muhafiz, code guard!
 *
 * Check codebase for given coding standards 
 * and prevent git commits if necessary 
 */ 
class Muhafiz
{
    public function __construct($dir)
    {
        chdir($dir); //change current directory to git repository
    }

    /**
     * check code by runners specified in 'muhafiz.active-runners' git config
     */
    public function run() 
    {
        $activeRunnersConfig = Utils_Git::getConfig("muhafiz.active-runners", "phpcs");
        $activeRunners = explode(",", $activeRunnersConfig);

        $stagedFiles = Utils_Git::getStagedFiles();

        foreach ($activeRunners as $activeRunner) {
            $activeRunner = trim($activeRunner);
            $className = "Runners_" . ucfirst($activeRunner) . "_" .ucfirst($activeRunner);
            if (class_exists($className) && is_subclass_of($className, "Runners_Abstract")) {
                $runner = new $className();
                echo "running $activeRunner \n";
                $runner->apply($stagedFiles['output']);
            } else {
                throw new Exception("$activeRunner runner not defined!");
            }
        }

    }
}
