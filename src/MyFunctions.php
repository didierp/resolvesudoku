<?php

require_once(dirname(__FILE__) . "/Grid.php");

class MyFunctions {

	public static function displayGrid(string $res) {

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

	public static function getLines(string $grid): array {
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

	public static function getColumns(string $grid): array {
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

	public static function getSquares(string $grid): array {
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

	public static function getLineFromOffset(int $offset): int {
		return (int)($offset / 9);
	}

	public static function getColumnFromOffset(int $offset): int {
		return $offset % 9;
	}

	public static function getSquare(int $line, int $column): int {
		return 3 * ((int)($line / 3)) + (int)($column / 3);
	}

	public static function getSquareFromOffset(int $offset): int {
		return 3 * ((int)((int)($offset / 9) / 3)) + (int)($offset % 9 / 3);
	}

	public static function getPositionInSquare(int $line, int $column): int {
		return (($line % 3) * 3) + ($column % 3);
	}

}