<?php

class Grid {
	/**
	 * @var string
	 */
	public $res = "";
	/**
	 * @var array
	 */
	public $squares = [];
	/**
	 * @var array
	 */
	public $columns = [];
	/**
	 * @var array
	 */
	public $lines;
	/**
	 * @var string
	 */
	public $old = "";
	/**
	 * @var array
	 */
	public $oldSquares = [];
	/**
	 * @var array
	 */
	public $oldColumns = [];
	/**
	 * @var array
	 */
	public $oldLines = [];
	/**
	 * @var array
	 */
	public $oldPos = [];
	/**
	 * @var array
	 */
	public $oldRes = [];
	/**
	 * @var array
	 */
	public $oldKeyPos = [];
	/**
	 * @var int
	 */
	public $count = 0;
	/**
	 * @var int
	 */
	public $countPos;
	/**
	 * @var int
	 */
	public $countOld;
	/**
	 * @var array
	 */
	public $pos;
	/**
	 * @var int|null
	 */
	private $keyPos;
	/**
	 * @var int
	 */
	private $countNoValue = 0;
	/**
	 * @var int
	 */
	private $countUniqueValue = 0;
	/**
	 * @var int
	 */
	private $countFoundValue = 0;
	/**
	 * @var int
	 */
	private $countChoicedValue = 0;

	public function __construct($grid) {
		$this->res = $grid;
		$this->squares = MyFunctions::getSquares($this->res);
		$this->columns = MyFunctions::getColumns($this->res);
		$this->lines = MyFunctions::getLines($this->res);
	}

	public function getRes(): string {
		$debut = microtime();
		while (strpos($this->res, '-') !== false) {
			if ($this->count >= 1000) {
				echo "1000loops\n";
				break;
			}
			echo "$this->res\n";
			if ($this->old == $this->res) {
				$this->countOld = 0;
				$this->getKeyPos();
				if ($this->keyPos !== null) {
					$this->initChoice();
				}
			} else {
				$this->searchUniqueSolution();
			}
			$this->count++;
		}

		echo "count: $this->count\n";
		echo "countChoicedValue: $this->countChoicedValue\n";
		echo "countFoundValue: $this->countFoundValue\n";
		echo "countNoValue: $this->countNoValue\n";
		echo "countUniqueValue: $this->countUniqueValue\n";
		$fin = microtime();
		$delay = $fin - $debut;
		echo "delay: $delay\n";

		return $this->res;
	}

	private function getKeyPos() {
		$keyPos = null;
		foreach ($this->pos as $key => $value) {
			if (!in_array($key, $this->oldKeyPos)) {
				if (count($value) == 2) {
					$keyPos = $key;
					break;
				} else {
					$this->countPos = count($value);
					if ($this->countPos > 0 && $this->countPos < $this->countOld) {
						$keyPos = $key;
					}
				}
				$this->countOld = count($value);
			}
		}
		$this->countChoicedValue++;
		$this->keyPos = $keyPos;
	}

	private function initChoice() {
		$this->oldKeyPos[] = $this->keyPos;
		$this->oldSquares[] = $this->squares;
		$this->oldColumns[] = $this->columns;
		$this->oldLines[] = $this->lines;
		$this->oldRes[] = $this->res;
		$choice = $this->pos[$this->keyPos][0];
		unset($this->pos[$this->keyPos][0]);
		$this->oldPos[] = $this->pos[$this->keyPos];
		$this->setChoice($this->keyPos, $choice);
	}

	private function returnPreviousChoice() {
		$this->pos = [];
		// if faut revenir en arrière sur le dernier choix
		$indexPos = count($this->oldPos) - 1;
		if ($indexPos !== null && $indexPos >= 0) {
			if (count($this->oldPos[$indexPos]) > 0) {
				$oldPosIndexPosIndexPosKey = array_pop($this->oldPos[$indexPos]);
				$lastKey = $this->oldKeyPos[$indexPos];
				if ($lastKey !== null) {
					$this->res = $this->oldRes[$indexPos];
					$this->squares = $this->oldSquares[$indexPos];
					$this->columns = $this->oldColumns[$indexPos];
					$this->lines = $this->oldLines[$indexPos];
					if (count($this->oldPos[$indexPos]) == 0) {
						$this->popArray();
					}
					$this->setChoice($lastKey, $oldPosIndexPosIndexPosKey);
				}
			}
		}
	}

	private function searchUniqueSolution() {
		$this->old = $this->res;
		$this->pos = [];
		$firstPos = strpos($this->res, '-');
		$lastPos = strrpos($this->res, '-');
		for ($offsetCar = $firstPos; $offsetCar <= $lastPos; $offsetCar++) {
			if (substr($this->res, $offsetCar, 1) == '-') {
				$this->pos[$offsetCar] = [];
				for ($val = 1; $val <= 9; $val++) {
					$l = MyFunctions::getLineFromOffset($offsetCar);
					if (!in_array($val, $this->lines[$l])) {
						$c = MyFunctions::getColumnFromOffset($offsetCar);
						$s = MyFunctions::getSquare($l, $c);
						if (!in_array($val, $this->squares[$s])) {
							if (!in_array($val, $this->columns[$c])) {
								$this->pos[$offsetCar][] = $val;
								$this->countFoundValue++;
							}
						}
					}
				}
				if (count($this->pos[$offsetCar]) == 1 && $this->pos[$offsetCar][0] !== null) {
					$this->countUniqueValue++;
					$this->setResForUniqueChoice($offsetCar, $this->pos[$offsetCar][0]);
					$this->setGridForUniqueChoices($l, $c, $s, $this->pos[$offsetCar][0]);
				} elseif (count($this->pos[$offsetCar]) == 0) {
					$this->countNoValue++;
					$this->returnPreviousChoice();
					break;
				}
			}
		}
	}

	private function popArray() {
		array_pop($this->oldPos);
		array_pop($this->oldKeyPos);
		array_pop($this->oldSquares);
		array_pop($this->oldColumns);
		array_pop($this->oldLines);
		array_pop($this->oldRes);
	}

	private function setGridForUniqueChoices($l, $c, $s, $charInOffset) {
		$this->squares[$s][MyFunctions::getPositionInSquare($l, $c)] = $charInOffset;
		$this->columns[$c][$l] = $charInOffset;
		$this->lines[$l][$c] = $charInOffset;
	}

	private function setResForUniqueChoice($offsetCar, $charInOffset) {
		if ($offsetCar == 0) {
			$this->res = $charInOffset . substr($this->res, $offsetCar + 1);
		} else {
			$this->res = substr($this->res, 0, $offsetCar) . $charInOffset . substr($this->res, $offsetCar + 1);
		}
	}

	private function setChoice($lastKey, $oldPosIndexPosIndexPosKey) {
		$l = MyFunctions::getLineFromOffset($lastKey);
		$c = MyFunctions::getColumnFromOffset($lastKey);
		$s = MyFunctions::getSquare($l, $c);
		$this->setGridForUniqueChoices($l, $c, $s, $oldPosIndexPosIndexPosKey);
		$this->setResForUniqueChoice($lastKey, $oldPosIndexPosIndexPosKey);
	}
}