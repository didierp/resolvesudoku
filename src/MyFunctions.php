<?php

require_once(dirname(__FILE__) . "/Grid.php");

class MyFunctions {

	public static function displayGrid($res) {

		?>
		<table>
			<tr>
				<?php
				for ($i = 0;
				$i < 81;
				$i++) {
				if ($i % 9 == 0) {
				?></tr>
			<tr><?php
				}
				?>
				<td><input type="text" id="0_0" name="0_0" value="<?php echo substr($res, $i, 1) ?>"/></td><?php
				} ?>
			</tr>
		</table>
		<div>
			<input type="submit">
		</div>
		</form>

		<?php
	}

	public static function getLines($grid): array {
		$lines = [];
		$offset = 0;
		for ($i = 0; $i < 9; $i++) {
			for ($j = 0; $j < 9; $j++) {
				$lines[$i][$j] = substr($grid, $offset + $j, 1);
			}
			$offset = $offset + 9;
		}

		return $lines;
	}

	public static function getColumns($grid): array {
		$columns = [];
		for ($i = 0; $i < 9; $i++) {
			$offset = $i;
			for ($j = 0; $j < 9; $j++) {
				$columns[$i][] = substr($grid, $offset, 1);
				$offset = $offset + 9;
			}
		}

		return $columns;
	}

	public static function getSquares($grid): array {
		$squares = [];
		for ($i = 0; $i < 9; $i++) {
			$offset = 27 * (int)($i / 3) + (($i - (3 * (int)($i / 3))) * 3);
			for ($j = 0; $j < 3; $j++) {
				$squares[$i][] = substr($grid, $offset, 1);
				$squares[$i][] = substr($grid, $offset + 1, 1);
				$squares[$i][] = substr($grid, $offset + 2, 1);
				$offset = $offset + 9;
			}
		}

		return $squares;
	}

	public static function getLineFromOffset(int $offsetCar): int {
		return (int)($offsetCar / 9);
	}

	public static function getColumnFromOffset(int $offsetCar): int {
		return $offsetCar % 9;
	}

	public static function getSquare($l, $c): int {
		return 3 * ((int)($l / 3)) + (int)($c / 3);
	}

	public static function getSquareFromOffset(int $offsetCar): int {
		return 3 * ((int)((int)($offsetCar / 9) / 3)) + (int)($offsetCar % 9 / 3);
	}

	public static function getPositionInSquare($l, $c): int {
		return (($l % 3) * 3) + ($c % 3);
	}

}