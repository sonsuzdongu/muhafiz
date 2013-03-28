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
use Muhafiz\Vcs\Git as Git;
use Muhafiz\Vcs\Subversion as Subversion;
use Muhafiz\Runners as Runners;


/**
 * Muhafiz, code guard!
 *
 * Check codebase for given coding standards 
 * and prevent vcs commits if necessary 
 */ 
class Muhafiz
{
    private $_vcs;

    /**
     * Init Muhafiz and run required methods by required parameters
     * @param array $configParams $GLOBALS passed from vcs hooks
     */
    public function init($configParams)
    {
        switch ($configParams['vcs']) {
            case 'subversion':
                $repository = $_SERVER['argv'][1];
                $txn = $_SERVER['argv'][2];

                $this->_vcs = new Subversion($configParams, $repository, $txn);
                break;
            case 'git':
                $this->_vcs = new Git($configParams);
                break;
        }

        if ($configParams['hookType'] == "pre-commit") {

            chdir($configParams['dir']); //change current directory to vcs repository
            $stagedFiles = $this->_vcs->getStagedFiles();
            $files = $stagedFiles['output'];
            $this->run($files);

        } elseif ($configParams['hookType'] == "pre-receive") {
            try {
                $this->_checkIfPushDisabled($configParams['ref']);
                $files = $this->_vcs->getFilesAfterCommit($configParams['rev1'], $configParams['rev2']);
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
     * @param string $ref vcs ref name
     */
    private function _checkIfPushDisabled($ref)
    {
        $branchName = str_replace("refs/heads/", "", $ref);
        if ($config = $this->_vcs->getConfig("muhafiz.disabled-branches", "")) {
            $branches = array_map("trim", explode(" ", $config));
            foreach ($branches as $branch) {
                if ($branch == $branchName) {
                    throw new Exceptions\BranchDisabled("Pushing to branch '${branchName}' have been disabled!");
                }
            }
        }
    }


    /**
     * check code by runners specified in 'muhafiz.active-runners' vcs config
     *
     * @param array $files list of files to be checked
     */
    public function run($files)
    {
        $activeRunnersConfig = $this->_vcs->getConfig("muhafiz.active-runners", "php, phpcs, jshint, lineend, bom");
        $activeRunners = explode(",", $activeRunnersConfig);

        foreach ($activeRunners as $activeRunner) {
            $activeRunner = str_replace('-', '', trim($activeRunner));
            $className = "Muhafiz\\Runners\\" . ucfirst($activeRunner);

            if (class_exists($className) && is_subclass_of($className, "\\Muhafiz\\Runners\\RunnersAbstract")) {
                $runner = new $className($this->_vcs);
                echo "running $activeRunner ... ";
                $runner->init($files);
                echo "DONE \n";

            } else {
                throw new Exceptions\RunnerNotDefined("${activeRunner} runner not defined!");
            }
        }
    }
}
