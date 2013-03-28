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


namespace Muhafiz;
use Muhafiz\Utils\System as Sys;
use Muhafiz\Utils\Git as Git;
use Muhafiz\Runners as Runners;


/**
 * Muhafiz, code guard!
 *
 * Check codebase for given coding standards 
 * and prevent git commits if necessary 
 */ 
class Muhafiz
{
    /**
     * Init Muhafiz and run required methods by required parameters
     * @param array $configParams $GLOBALS passed from git hooks
     */
    public function init($configParams)
    {
        if ($configParams['hookType'] == "pre-commit") {

            chdir($configParams['dir']); //change current directory to git repository
            $stagedFiles = Git::getStagedFiles();
            $files = $stagedFiles['output'];
            $this->run($files);

        } elseif ($configParams['hookType'] == "pre-receive") {
            try {
                $this->_checkIfPushDisabled($configParams['ref']);
                $files = Git::getFilesAfterCommit($configParams['rev1'], $configParams['rev2']);
                $this->run($files);
            }
            catch(Exception $e){
                //files on pre-receive hook are temporary files
                //and should be removed
                Sys::removeFiles($files);

                //throw exception to bootsrap again
                throw $e;
            }
        }
    }


    /**
     * Check if pushing to branch is disabled
     *
     * @param string $ref git ref name
     */
    private function _checkIfPushDisabled($ref)
    {
        $branchName = str_replace("refs/heads/", "", $ref);
        if ($config = Git::getConfig("muhafiz.disabled-branches", "")) {
            $branches = array_map("trim", explode(" ", $config));
            foreach ($branches as $branch) {
                if ($branch == $branchName) {
                    throw new Exceptions\BranchDisabled("Pushing to branch '${branchName}' have been disabled!");
                }
            }
        }
    }


    /**
     * check code by runners specified in 'muhafiz.active-runners' git config
     *
     * @param array $files list of files to be checked
     */
    public function run($files)
    {
    	$activeRunnersList = "php, phpcs, jshint, lineend, bom, forbiddenfile";
        $activeRunnersConfig = Git::getConfig("muhafiz.active-runners", $activeRunnersList);
        $activeRunners = explode(",", $activeRunnersConfig);

        foreach ($activeRunners as $activeRunner) {
            $activeRunner = str_replace('-', '', trim($activeRunner));
            $className = "Muhafiz\\Runners\\" . ucfirst($activeRunner);

            if (class_exists($className) && is_subclass_of($className, "\\Muhafiz\\Runners\\RunnersAbstract")) {
                $runner = new $className();
                echo "running $activeRunner ... ";
                $runner->init($files);
                echo "DONE \n";

            } else {
                throw new Exceptions\RunnerNotDefined("${activeRunner} runner not defined!");
            }
        }
    }
}
