<?php

class CDiceGame {
	protected $total;
	protected $round;
	protected $score;

	public function __construct() {
		$this->total = 0;
		$this->round = 0;
		$this->score = 0;
	}

	public function __get($property){
		if(property_exists($this, $property)) 
			return $this->$property;
		else 
			throw new Exception("$property did not exist!");
	}

	public function increaseTotal() {
		$this->total += $this->score;
	}
	public function increaseRound() {
		$this->round++;
	}
	public function increaseScore($score) {
		$this->score += $score;
	}
	public function resetScore() {
		$this->score = 0;
	}
}