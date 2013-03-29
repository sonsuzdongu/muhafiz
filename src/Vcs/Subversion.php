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

namespace Muhafiz\Vcs;

use Muhafiz\Utils\System as Sys;
use Muhafiz\Utils\Misc as Misc;
use Muhafiz\Vcs\VcsAbstract as VcsAbstract;

/**
 * Subversion helper which supplies a high-level API for svn command
 */
class Subversion extends VcsAbstract
{
    private $_repository;
    private $_txn;

    /**
     * constructs the object
     * @param array $configParams configuration parameters
     * @param string $repository working repository
     * @param string $txn transaction id
     */
    public function __construct($configParams)
    {
        parent::__construct($configParams);

        $this->_repository = $configParams['repository'];
        $this->_txn = $configParams['txn'];
    }


    /**
     * return list of staged files
     * @return array
     */
    public function getStagedFiles()
    {
        return Sys::runCommand(
            "svnlook changed -t {$this->_txn} {$this->_repository} | grep '^[U|A]' | awk '{print $2}'"
        );
    }


    /**
     * return list of new added files
     * @return array
     */
    public function getNewFiles()
    {
        throw new Exceptions\NotImplemented("getNewfiles() method is not defined for subversion!");
    }


    /**
     * Get list of files between revisions by generating last file as a tmp
     * source so we can get them on pre-receive hook
     *
     * @param string $firstRev first revision
     * @param string $secondRev revision after commit
     * @return array list of files
     */
    public function getFilesAfterCommit($firstRev, $secondRev)
    {
        throw new Exceptions\NotImplemented("getFilesAfterCommit() method is not defined for subversion!");
    }


    /**
     * read config from given key
     * @param string $key key to read
     * @param string|null $defaultValue default value for key, if value not set
     * @return string
     */
    public function getConfig($key, $defaultValue = null)
    {
        return Misc::readIniValue($this->_config['svnconfig'], $key, $defaultValue);
    }


    /**
     * Set svn config by key/value
     * @param string $key key to set
     * @param string $value value for key
     * @return boolean
     */
    public function setConfig($key, $value)
    {
        // $result = Sys::runCommand(
        //      "svnlook propset -t {$this->_txn} {$this->_repository} ${key} ${value} /"
        // );
        // return $result['exitCode'] == 0;
        throw new Exceptions\NotImplemented("setConfig() method is not defined for subversion!");
    }


    /**
     * Gets the cmd to print contents of changed file
     * @param string $file file to print
     * @return string cat cmd
     */
    public function catCommand($file)
    {
        return "svnlook cat -t {$this->_txn} {$this->_repository} ${file}";
    }


    /**
     * Determines the vcs uses stdout or not
     * @return bool true if vcs uses stdout
     */
    public function usesStdout()
    {
        return true;
    }
}
