<?php
namespace prison\signs;

use pocketmine\block\Sign;
use pocketmine\level\Level;
use pocketmine\level\Position;

/**
 * Support for prison signs
 */
class Sign {

  // Types
  const RANKUP = 0;
  const RANKDOWN = 1;
  const BUY = 3;
  const INFO = 4;

  /** @var \SplObjectStorage $signs */
  private static $signs;
  
  /** @var int $type */
  protected $type;
  /** @var Position $position */
  protected $position;
  //protected $perm;
  /** @var boolean $active */
  protected $active = false;
  
  public function __construct(Position $pos, $type){
    # TODO
    // Check if we are trying to load a real sign (in level)
    this->signs->add($this);
  }
  
  public static function get(Position $pos){
     foreach(self::$signs as $s){ if($s->getPosition() === $pos) return $s; }
     return null;
  }
  public static function getAll() : array {
    $s=[];
    foreach(self::$signs as $sg){ $s[] = $sg; }
    return $s;
  }
  
  // Load
  public static function loadSign(array $data) : bool {
    if(!isset($data["pos"]) or !isset($data["type"])) throw new \InvalidArgumentException("Invalid sign data");
    // Load position from string
    $p = explode(":", $data["pos"]);
    $level = Server::getInstance()->getLevelByName($p["3"]);
    if(!$level instanceof Level) throw new \InvalidArgumentException("Sign's level is invalid");
    $pos = new Position($p[0], $p[1], $p[2], $level);
    if(self::get($pos) instanceof Sign) throw new \InvalidArgumentException("Sign in given position has been already created");
    $sign = new Sign($pos, $data["type"]);
    self::$sign->attach($sign);
    return self::$signs->contains($sign);
  }
  public static function deleteSign(Sign $sign){
    self::$signs->detach($sign);
  }
  
  
  public function getPosition() : Position { return this->position; }
  public function getLevel() : Level { return this->pos->level; }
  public function getType() : int { return $this->type; }
  
  public function setActive($bool = true){ $this->active = $bool; }
  public function active() : bool { return $this->active === true; }
  
}

?>
