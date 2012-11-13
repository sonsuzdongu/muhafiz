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
 * Boostrap file used by git hook scripts
 * returns;
 *  0 on success
 *  1 on rule failed
 *  255 on other exceptions
 */
error_reporting(E_ALL);
ini_set("display_errors", true);

include_once("AutoLoader.php");
AutoLoader::getInstance();

$muhafiz = new Muhafiz($GLOBALS['dir']);

try {
    $muhafiz->run();
    exit(0);
}
catch(Exceptions_ToolNotFound $e) 
{
    echo "FATAL!!!\n";
    echo $e->getMessage() . "\n";
    exit(1);
}
catch(Exceptions_RuleFailed $e) 
{
    echo "Cannot continue commit, please fix these\n\n";
    echo $e->getMessage() . "\n";
    exit(1);
}
catch(Exception $e) 
{
    echo "Something went wrong\n\n";
    echo $e->getMessage() . "\n";
    exit(255);
}
