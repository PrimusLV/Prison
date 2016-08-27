<?php
namespace prison\event\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;

use prison\Prison;

class PlayerEventListener implements Listener {

  /** @var Prison $owner */
  private $owner;
  
  public function __construct(Prison $plugin){
    $this->owner = $plugin;
  }
  
  public function onPlayerInteract(PlayerInteractEvent $e){
    # TODO
  }
  
  
  
  protected function getPlugin() : Prison { return $this->owner; } #Useless
}
