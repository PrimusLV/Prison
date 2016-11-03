<?php
namespace prison\signs;

use pocketmine\block\Sign;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\utils\Config;

/**
 * Support for prison signs
 */
class PrisonSign extends Position {

  // Types
  const RANKUP = 0;
  const RANKDOWN = 1;
  const BUY = 3;
  const INFO = 4;

  /** @var \SplObjectStorage $signs */
  private static $signs;
  
  /** @var int $type */
  protected $type;

  /** @var boolean $active */
  protected $active = false;
  
  public function __construct(Position $pos, $type){
    parent::__construct($pos);
    $this->type = $type;
  }
  
  /**
   * Quick reminder for myself: This could not work because identical check won't work on diffrent position instances altough
   *    components are the same.
   * @return Sign|null
   */
  public static function get(Position $pos){
     foreach(self::$signs as $s){ 
      if($s->getFloorX() === $pos->getFloorX() && $s->getFloorY() === $pos->getFloorY() && $s->getFloorZ() === $pos->getFloorZ()){
        return $s;
      }  
    }
    return null;
  }
  
  /**
   * @return Sign[]
   */
  public static function getAll() : array {
    $s=[];
    foreach(self::$signs as $sg){ $s[] = $sg; }
    return $s;
  }
  
  public static function saveAll() {
    $signs = [];
  	foreach($this->signs as $sign) {
  		$signs[] = [
  			"x" => $sign->getX(),
  			"y" => $sign->getY(),
  			"z" => $sign->getZ(),
  			"level" => $sign->getLevel()
  			];
  	}
  	(new Config($this->getDataFolder() . "signs.json", Config::JSON, $signs))->save();
  }
  
  // Load
  public static function loadSign(array $data) : bool {
    if(!isset($data["type"])) throw new \InvalidArgumentException("Invalid sign data");
    // Load position from string
    $level = Server::getInstance()->getLevelByName($data["level"]);
    if(!$level instanceof Level) throw new \InvalidArgumentException("Sign's level is invalid");
    $pos = new Position((int) $data["x"], (int) $data["y"], (int) $data["z"], $level);
    if(self::get($pos) instanceof Sign) throw new \InvalidArgumentException("Sign in given position has been already created");
    $sign = new Sign($pos, $data["type"]);
    $block = $pos->getLevel()->getBlock($pos);
    if(!($block instanceof Sign)) throw new \RuntimeException("sign has to be attached to real sign");
    self::$sign->attach($sign);
    return self::$signs->contains($sign);
  }

  public static function deleteSign(Sign $sign){
    self::$signs->detach($sign);
  }
  
  
  public function getPosition() : Position { return $this->position; }
  public function getLevel() : Level { return $this->pos->level; }
  public function getType() : int { return $this->type; }
  
  public function setActive($bool = true){ $this->active = $bool; }
  public function active() : bool { return $this->active === true; }
  
  public function onTap(Player $player) {
    if(!$this->active()) return;
    switch($this->type) {
      case self::RANKUP:
        break;
      case self::BUY:
        break;
      case self::RANKDOWN:
        break;
      case self::INFO:
        break;
      default:
        // Invalid sign?
        self::deleteSign($this);
        break;
    }
  }
  
}

?>
