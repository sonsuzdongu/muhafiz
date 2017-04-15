<?php 

namespace Muhafiz\Runners;
use Muhafiz\Utils\System as Sys;
use Muhafiz\Runners\RunnersAbstract as RunnersAbstract;

class Yaml extends RunnersAbstract{
	protected $_name = 'Yaml';
	protected $_toolName = "yaml";
	protected $_toolCheckCommand = "php -i | grep yaml";
	protected $_fileFilterRegexp = "/.*\.(yml|yaml)$/";

	function run(array $files) {
		foreach ($files as $file) {
			$contents = fread(fopen($file, "r"), filesize($file));
			$parse = yaml_parse($contents);
			if (!is_array($parse)) {
				$out['output'][] = "'${file}' is not valid.";
				$this->_onRuleFailed($out);
 			}
		}
	}
}
?>
