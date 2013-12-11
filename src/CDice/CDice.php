<?php

class CDice {

  protected $faces;
  protected $rolls = array();

  public function __construct($faces=6) {
    $this->faces = $faces;
  }


  /**
   * Roll the dice
   *
   */
  public function Roll($times) {
    $this->rolls = array();

    for($i = 0; $i < $times; $i++) {
      $this->rolls[] = rand(1, $this->faces);
    }
  }
  
  public function getLastRoll() {
    return $this->rolls[0];
  }

  /**
   * Get the total from the last roll(s).
   *
   */
  public function GetTotal() {
    return array_sum($this->rolls);
  }


  /**
   * Get the average from the last roll(s).
   *
   */
  public function GetAverage() {
    return round(array_sum($this->rolls) / count($this->rolls), 1);
  }
  public function __get($property) {
    if(property_exists($this, $property)) {
      return $this->property;
    }
  }
  
  /**
   * Get the rolls as a string with each roll separated by a comma.
   *
   */
  public function GetRollsAsSerie() {
    $html = null;
    foreach($this->rolls as $val) {
      $html .= "{$val}, ";
    }
    return substr($html, 0, strlen($html) - 2);
  }
}