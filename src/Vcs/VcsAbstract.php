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

/**
 * Vcs which supplies a high-level API for vcs utilities
 */
abstract class VcsAbstract
{
    protected $_config;

    /**
     * constructs the object
     * @param array $configParams configuration parameters
     */
    public function __construct($configParams) {
        $this->_config = $configParams;
    }

    /**
     * return list of staged files
     * @return array
     */
    public abstract function getStagedFiles();


    /**
     * return list of new added files
     * @return array
     */
    public abstract function getNewFiles();


    /**
     * Get list of files between revisions by generating last file as a tmp
     * source so we can get them on pre-receive hook
     *
     * @param string $firstRev first revision
     * @param string $secondRev revision after commit
     * @return array list of files
     */
    public abstract function getFilesAfterCommit($firstRev, $secondRev);


    /**
     * read config from given key
     * @param string $key key to read
     * @param string|null $defaultValue default value for key, if value not set
     * @return string
     */
    public abstract function getConfig($key, $defaultValue = null);


    /**
     * Set vcs config by key/value
     * @param string $key key to set
     * @param string $value value for key
     * @return boolean
     */
    public abstract function setConfig($key, $value);

    
    /**
    * Gets the cmd to print contents of changed file
    * @param string $file file to print
    */
    public abstract function catCommand($file);
}
