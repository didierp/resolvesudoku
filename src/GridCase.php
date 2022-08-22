<?php

class GridCase {
	/**
	 * @var int
	 */
	private $line;
	/**
	 * @var int
	 */
	private $column;
	/**
	 * @var int
	 */
	private $square;
	/**
	 * @var int
	 */
	private $offset;

	/**
	 * @param int $offset
	 */
	public function __construct(int $offset) {
		$this->offset = $offset;
		$this->line = MyFunctions::getLineFromOffset($this->offset);
		$this->column = MyFunctions::getColumnFromOffset($this->offset);
		$this->square = MyFunctions::getSquare($this->line, $this->column);
	}

	public function getLine(): int {
		return $this->line;
	}

	public function getSquare(): int {
		return $this->square;
	}

	public function getColumn(): int {
		return $this->column;
	}
}