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
     foreach($this->signs as $s){ if($s->getPosition() === $pos) return $s; }
     return null;
  }
  public static function getAll() : array {
    $s=[];
    foreach($this->signs as $sg){ $s[] = $sg; }
    return $s;
  }
  
  // Load
  public static function loadSign(array $data) : bool {
    # TODO
  }
  public static function deleteSign(Sign $sign){
    # TODO
  }
  
  
  public function getPosition() : Position { return this->position; }
  public function getLevel() : Level { return this->pos->level; }
  public function getType() : int { return $this->type; }
  
}

?>
