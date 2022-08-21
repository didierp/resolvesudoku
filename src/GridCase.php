<?php

class GridCase {
	/**
	 * @var int
	 */
	private $l;
	/**
	 * @var int
	 */
	private $c;
	/**
	 * @var int
	 */
	private $s;
	/**
	 * @var int
	 */
	private $offsetCar;

	/**
	 * @param int $offsetCar
	 */
	public function __construct(int $offsetCar) {
		$this->offsetCar = $offsetCar;
		$this->l = MyFunctions::getLineFromOffset($offsetCar);
		$this->c = MyFunctions::getColumnFromOffset($offsetCar);
		$this->s = MyFunctions::getSquare($this->l, $this->c);
	}

	public function getLine(): int {
		return $this->l;
	}

	public function getSquare(): int {
		return $this->s;
	}

	public function getColumn(): int {
		return $this->c;
	}
}