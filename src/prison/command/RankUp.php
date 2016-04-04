<?php
namespace prison\command;

use pocketmine\command\Command;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat as Text;
use pocketmine\Player;

use prison\Prison;

use _64FF00\PurePerms\PPGroup;

class RankUp extends Command implements PluginIdentifiableCommand {
	
	public function __construct(Prison $plugin, $name, $description, $usage, array $aliases){
		parent::__construct($name, $description, $usage, $aliases);
		$this->setPermission('prison.rankup');

		$this->plugin = $plugin;
	}

	public function execute(CommandSender $sender, $label, array $args){
		if(!$this->testPermission($sender)){
			$sender->sendMessage(Text::RED."".$this->getPermissionMessage());
			return true;
		}
		if(!$sender instanceof Player){
			$sender->sendMessage(Text::RED."Run this command in-game!");
			return true;
		}
		
		$this->getPlugin()->rankup($sender);	

	}

	public function getPlugin(){
		return $this->plugin;
	}

}