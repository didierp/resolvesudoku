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
	 * @var int|null
	 */
	public $oldPosIndexPosIndexPosKey = null;
	/**
	 * @var int
	 */
	public $count;
	/**
	 * @var int
	 */
	public $countPos;
	/**
	 * @var int|null
	 */
	public $choice;
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

	public function __construct($grid) {
		$this->res = $grid;
		$this->squares = MyFonctions::getSquares($this->res);
		$this->columns = MyFonctions::getColumns($this->res);
		$this->lines = MyFonctions::getLines($this->res);
	}

	public function getRes(): string {
		while (strpos($this->res, '-') !== false) {
			if ($this->count >= 1000) {
				echo "1000loops\n";
				break;
			}
			echo "$this->res\n";
			if ($this->old == $this->res) {
				echo "old == res\n";
				$this->countOld = 0;
				$this->getKeyPos();
				if ($this->keyPos !== null) {
					echo "find\n";
					$this->initChoice();
				}
			} else {
				echo "old != res\n";
				$this->searchUniqueSolution();
			}
			$this->count++;
		}

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

		$this->keyPos = $keyPos;
	}

	private function initChoice() {
		$this->oldKeyPos[] = $this->keyPos;
		$this->oldSquares[] = $this->squares;
		$this->oldColumns[] = $this->columns;
		$this->oldLines[] = $this->lines;
		$this->oldRes[] = $this->res;
		$this->choice = $this->pos[$this->keyPos][0];
		echo "break1 $this->keyPos => {$this->pos[$this->keyPos][0]}\n";
		unset($this->pos[$this->keyPos][0]);
		$this->oldPos[] = $this->pos[$this->keyPos];
		$this->setAChoice();
	}

	private function returnPreviousChoice() {
		$this->pos = [];
		// if faut revenir en arrière sur le dernier choix
		$indexPos = count($this->oldPos) - 1;
		if ($indexPos !== null && $indexPos >= 0) {
			if (count($this->oldPos[$indexPos]) > 0) {
				$this->oldPosIndexPosIndexPosKey = array_pop($this->oldPos[$indexPos]);
				$lastKey = $this->oldKeyPos[$indexPos];
				if ($lastKey !== null) {
					$this->res = $this->oldRes[$indexPos];
					$this->squares = $this->oldSquares[$indexPos];
					$this->columns = $this->oldColumns[$indexPos];
					$this->lines = $this->oldLines[$indexPos];
					if (count($this->oldPos[$indexPos]) == 0) {
						$this->popArray();
					}
					$this->setPreviousChoice($lastKey);
					if (strlen($this->res) != 81) {
						echo "too long3\n";
					}
				}
			}
		}
	}

	private function setAChoice() {
		$this->setResForUniqueChoice($this->keyPos, $this->choice);
		$l = MyFonctions::getLineFromOffset($this->keyPos);
		$c = MyFonctions::getColumnFromOffset($this->keyPos);
		$s = MyFonctions::getSquare($l, $c);
		$this->setGridForUniqueChoices($l, $c, $s, $this->choice);
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
					$l = MyFonctions::getLineFromOffset($offsetCar);
					if (!in_array($val, $this->lines[$l])) {
						$c = MyFonctions::getColumnFromOffset($offsetCar);
						$s = MyFonctions::getSquare($l, $c);
						if (!in_array($val, $this->squares[$s])) {
							if (!in_array($val, $this->columns[$c])) {
								$this->pos[$offsetCar][] = $val;
							}
						}
					}
				}
				if (count($this->pos[$offsetCar]) == 1 && $this->pos[$offsetCar][0] !== null) {
					echo "unique value $offsetCar {$this->pos[$offsetCar][0]}\n";
					$this->setResForUniqueChoice($offsetCar, $this->pos[$offsetCar][0]);
					$this->setGridForUniqueChoices($l, $c, $s, $this->pos[$offsetCar][0]);
				} elseif (count($this->pos[$offsetCar]) == 0) {
					echo "no value $offsetCar\n";
					$this->returnPreviousChoice();
					echo "break3\n";
					break;
				}
			}
		}
	}

	private function setPreviousChoice($lastKey) {
		$l = MyFonctions::getLineFromOffset($lastKey);
		$c = MyFonctions::getColumnFromOffset($lastKey);
		$s = MyFonctions::getSquare($l, $c);
		$this->setGridForUniqueChoices($l, $c, $s, $this->oldPosIndexPosIndexPosKey);
		echo "new value $lastKey $this->oldPosIndexPosIndexPosKey\n";
		$this->setResForUniqueChoice($lastKey, $this->oldPosIndexPosIndexPosKey);
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
		$this->squares[$s][MyFonctions::getPositionInSquare($l, $c)] = $charInOffset;
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
}