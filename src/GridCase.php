<?php

class GridCase {
	/**
	 * @var int
	 */
	public $l;
	/**
	 * @var int
	 */
	public $c;
	/**
	 * @var int
	 */
	public $s;
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
}