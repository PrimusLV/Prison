<?php
# Economy
namespace prison\economy;

use pocketmine\Server;
use pocketmine\plugin\Plugin;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class Economy {

	private $economy, $owner;
	
	public function __construct(Plugin $plugin, $preffered){
		$this->owner = $plugin;
	        $economy = ["EconomyAPI", "PocketMoney", "MassiveEconomy", "GoldStd"];
	        $ec = [];
	        foreach($economy as $e){
	            $ins = $plugin->getServer()->getPluginManager()->getPlugin($e);
	            if($ins instanceof Plugin && $ins->isEnabled()){
	                $ec[$ins->getName()] = $ins;
	            }
	        }
	        if(isset($ec[$preffered])){
	        	$this->economy = $ec[$preffered];
	        } else {
	        	if(!empty($ec)){
	        		$this->economy = $ec[array_rand($e)];
	        	}
	        }
	        if($this->isLoaded()){
	        	$this->owner->getLogger()->info("Economy plugin: ".TextFormat::GOLD."".$this->getName());
	        }
	}
	
	public function takeMoney(Player $player, $ammount, $force = false){
		if($this->getName() === 'EconomyAPI'){
			return $this->economy->reduceMoney($player, $ammount, $force);
		}
		if($this->getName() === 'PocketMoney'){
			return $this->economy->grantMoney($player, $ammount, $force);
		}
		if($this->getName() === 'GoldStd'){
			return $this->economy->grantMoney($player, $ammount, $force); // CHECK
		}
		if($this->getName() === 'MassiveEconomy'){
			return $this->economy->takeMoney($player, $ammount, $force);
		}
		return false;
	}
	
	public function getMoney(Player $player){
		if($this->getName() === 'EconomyAPI'){
			return $this->economy->myMoney($player);
		}
		if($this->getName() === 'PocketMoney'){
			return $this->economy->getMoney($player->getName());
		}
		if($this->getName() === 'GoldStd'){
			return $this->economy->getMoney($player); // Check
		}
		if($this->getName() === 'MassiveEconomy'){
			if($this->economy->isPlayerRegistered($player->getName())){
			return $this->economy->getMoney($player->getName());
		}
		}
	}
	
	public function getMonetaryUnit(){
		if($this->getName() === 'EconomyAPI'){
			return $this->economy->getMonetaryUnit();
		}
		if($this->getName() === 'PocketMoney'){
			return 'PM';
		}
		if($this->getName() === 'GoldStd'){
			return 'G';
		}
		if($this->getName() === 'MassiveEconomy'){
			return $this->economy->getMoneySymbol() != null ? $this->economy->getMoneySymbol() : '$';
		}
	}
	
	public function formatMoney($ammount){
		if($this->getName() === 'EconomyAPI'){
			return $this->getMonetaryUnit().$ammount;
		}
		if($this->getName() === 'PocketMoney'){
			return $ammount.' '.$this->getMonetaryUnit();
		}
		if($this->getName() === 'GoldStd'){
			return $ammount.$this->getMonetaryUnit();
		}
		if($this->getName() === 'MassiveEconomy'){
			return $this->getMonetaryUnit().$ammount;
		}
		return $ammount;
	}
	public function isLoaded(){
		return $this->economy instanceof Plugin;
	}

	public function getApi(){
		return $this->economy;
	}
	
	public function getName(){
		return $this->economy->getDescription()->getName();
	}

}
