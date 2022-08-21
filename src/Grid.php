<?php

require_once(dirname(__FILE__) . "/GridCase.php");

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
	public $previousRes = "";
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
	private $countChoicedValue = 0;

	/**
	 * @param string $grid
	 */
	public function __construct(string $grid) {
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
			if ($this->previousRes == $this->res) {
				$this->countOld = 0;
				$keyPos = $this->getKeyPos();
				if ($keyPos !== null) {
					$this->initChoice($keyPos);
				}
			} else {
				$this->searchUniqueSolution();
			}
			$this->count++;
		}

		echo "count: $this->count\n";
		echo "countChoicedValue: $this->countChoicedValue\n";
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
		$this->countChoicedValue++;

		return $keyPos;
	}

	private function initChoice($keyPos) {
		$this->oldKeyPos[] = $keyPos;
		$this->oldSquares[] = $this->squares;
		$this->oldColumns[] = $this->columns;
		$this->oldLines[] = $this->lines;
		$this->oldRes[] = $this->res;
		$choice = $this->pos[$keyPos][0];
		unset($this->pos[$keyPos][0]);
		$this->oldPos[] = $this->pos[$keyPos];
		$this->setChoice($keyPos, $choice);
	}

	private function returnPreviousChoice() {
		$this->pos = [];
		// if faut revenir en arrière sur le dernier choix
		$indexPos = count($this->oldPos) - 1;
		if ($indexPos !== null && $indexPos >= 0) {
			if (count($this->oldPos[$indexPos]) > 0) {
				$oldPosIndexPosKey = array_pop($this->oldPos[$indexPos]);
				$lastKey = $this->oldKeyPos[$indexPos];
				if ($lastKey !== null) {
					$this->res = $this->oldRes[$indexPos];
					$this->squares = $this->oldSquares[$indexPos];
					$this->columns = $this->oldColumns[$indexPos];
					$this->lines = $this->oldLines[$indexPos];
					if (count($this->oldPos[$indexPos]) == 0) {
						$this->popArray();
					}
					$this->setChoice($lastKey, $oldPosIndexPosKey);
				}
			}
		}
	}

	private function searchUniqueSolution() {
		$tabRef = range(1, 9);
		$this->previousRes = $this->res;
		$this->pos = [];
		$firstPos = strpos($this->res, '-');
		do {
			$offsets[] = $firstPos;
			$offset = $firstPos + 1;
			$firstPos = strpos($this->res, '-', $offset);
		} while ($firstPos !== false);
		foreach ($offsets as $offsetCar) {
			$this->pos[$offsetCar] = [];
			$case = new GridCase($offsetCar);
			$diff = array_diff($tabRef, $this->lines[$case->l], $this->squares[$case->s], $this->columns[$case->c]);
			sort($diff);
			$this->pos[$offsetCar] = $diff;
			if (count($this->pos[$offsetCar]) == 1 && $this->pos[$offsetCar][0] !== null) {
				$this->countUniqueValue++;
				$this->setResForUniqueChoice($offsetCar, $this->pos[$offsetCar][0]);
				$this->setGridForUniqueChoices($case, $this->pos[$offsetCar][0]);
			} elseif (count($this->pos[$offsetCar]) == 0) {
				$this->countNoValue++;
				$this->returnPreviousChoice();
				break;
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

	private function setGridForUniqueChoices($case, $charInOffset) {
		$this->squares[$case->s][MyFunctions::getPositionInSquare($case->l, $case->c)] = $charInOffset;
		$this->columns[$case->c][$case->l] = $charInOffset;
		$this->lines[$case->l][$case->c] = $charInOffset;
	}

	private function setResForUniqueChoice($offsetCar, $charInOffset) {
		$this->res = (($offsetCar == 0) ? '' : substr($this->res, 0, $offsetCar)) . $charInOffset . substr($this->res, $offsetCar + 1);
	}

	private function setChoice($lastKey, $oldPosIndexPosIndexPosKey) {
		$case = new GridCase($lastKey);
		$this->setGridForUniqueChoices($case, $oldPosIndexPosIndexPosKey);
		$this->setResForUniqueChoice($lastKey, $oldPosIndexPosIndexPosKey);
	}
}