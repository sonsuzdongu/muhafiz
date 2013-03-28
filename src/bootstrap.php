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
 * Boostrap file used by vcs hook scripts
 * returns;
 *  0 on success
 *  1 on rule failed
 *  255 on other exceptions
 */
error_reporting(E_ALL);
ini_set("display_errors", true);

include_once("AutoLoader.php");
AutoLoader::getInstance();

$muhafiz = new Muhafiz\Muhafiz();
try {
    $muhafiz->init($GLOBALS);
    exit(0);
}
catch(\Muhafiz\Exceptions\ToolNotFound $e) 
{
    error_log("FATAL!!!");
    error_log($e->getMessage());
    exit(1);
}
catch(\Muhafiz\Exceptions\ToolNotFound $e) 
{
    error_log("FATAL!!!");
    error_log($e->getMessage());
    exit(1);
}
catch(\Muhafiz\Exceptions\RuleFailed $e) 
{
    error_log("Cannot continue commit, please fix these\n");
    error_log($e->getMessage());

    if ($GLOBALS['vcs'] == "git" && $GLOBALS['hookType'] == "pre-commit") {
        error_log("-----\nYou can bypass this check with 'git commit -n', or you can remove this runner\n-----");
    }

    exit(1);
}
catch(\Exception $e) 
{
    error_log("Something went wrong\n");
    error_log($e->getMessage());
    exit(255);
}
