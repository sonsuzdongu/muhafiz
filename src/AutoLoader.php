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
 *  AutoLoad class' php files with given directory structure
 *
 *  Foo_Bar will include Foo/Bar.php
 */
class AutoLoader
{
    private static $_instance;
    private $_externalSources = array();
    private $_dirSeparator   = "/";
    private $_classSeparator   = "_";

    /**
     * get singleton instance 
     */
    public static function getInstance() 
    {
        if (!isset(self::$_instance)) {
            $thisClass = get_called_class();
            self::$_instance = new $thisClass;
        }

        return self::$_instance;
    }

    /**
     * Register handler on construct
     */
    protected function __construct()
    {
        $this->_register();
    }

    /**
     * This method will handle autoload events
     */
    function loadHandler($className)
    {

        $requirePath = null;

        // Look for external resources and include source path
        
        foreach ((array)$this->_externalSources as $sourceName=>$sourcePath) {
            if ($className == $sourceName) {
                $requirePath = $sourcePath;
            }
        }
        if (!$requirePath) {
            // explode class name and include file 
            $namespaces = explode($this->_classSeparator, $className);
            $filepath = implode($this->_dirSeparator, $namespaces);
            $requirePath = $filepath . ".php";
        }

        @include_once($requirePath);
    }


    /**
     * Add external resources to include
     */
    function addExternalSource($className, $path)
    {
        $this->_externalSources[$className] = $path;
    }

    /**
     * Register autoloader handler
     */
    function _register()
    {
        $this->addNewHandler(array($this, "loadHandler"));
    }

    function addNewHandler($handler)
    {
        spl_autoload_register($handler);
    }
}
