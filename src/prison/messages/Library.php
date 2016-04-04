<?php
namespace prison\messages;

use pocketmine\utils\TextFormat as Text;
use pocketmine\utils\Config;

use prison\Prison;

class Library {
	
	protected $plugin;

	public static $prefix = "";

	public function __construct(Prison $plugin, $prefix = "[Prison]"){
		$this->plugin = $plugin;

		if(!file_exists($plugin->getDataFolder()."messages.yml")) $plugin->saveResource("messages.yml");
		$this->config = new Config($plugin->getDataFolder()."messages.yml", Config::YAML);
		$this->config->save();
		$this->config->reload();

		self::$prefix = $prefix;
	}

	/**
     * @param string $needle
     * @param array $vars
     * @return string
     */
    public function getMessage($needle, ...$vars) : string
    {
        if ($msg = $this->config->get($needle)) {
            if (is_array($msg)) {
                $ms = "";
                foreach ($msg as $m) {
                    $ms .= $m . "\n";
                }

                $msg = $ms;
            }
            $i = 1;
            foreach ($vars as $var) {
                $msg = str_replace("%var" . $i, $var, $msg);
                $i++;
            }
            $msg = str_replace("%prefix", self::$prefix, $msg);
            return trim($msg);
        } else {
            $this->getPlugin()->getLogger()->debug("Message: '$needle' not found!");
            return "";
        }
    }

	public function getPlugin() : Prison {
		return $this->plugin;
	}
}