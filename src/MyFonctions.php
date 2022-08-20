<?php

require_once(dirname(__FILE__) . "/Grid.php");


class MyFonctions {

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

	public static function getRes($grid): string {
		$res = $grid;
		$count = 0;
		$squares = MyFonctions::getSquares($grid);
		$columns = MyFonctions::getColumns($grid);
		$lines = MyFonctions::getLines($grid);
		$old = '';
		$oldSquares = [];
		$oldColumns = [];
		$oldLines = [];
		$oldPos = [];
		$oldRes = [];
		$oldKeyPos = [];
		while (strpos($res, '-') !== false) {
			if ($count >= 1000) {
				echo "1000loops\n";
				break;
			}
			echo "$res\n";
			if ($old == $res) {
				echo "old == res\n";
				$countOld = 0;
				$keyPos = 0;
				$find = false;
				foreach ($pos as $key => $value) {
					if (!in_array($key, $oldKeyPos)) {
						if (count($value) == 2) {
							$keyPos = $key;
							$find = true;
							break;
						} else {
							$countPos = count($value);
							if ($countPos > 0 && $countPos < $countOld) {
								$keyPos = $key;
								$find = true;
							}
						}
						$countOld = count($value);
					}
				}
				if ($find) {
					echo "find\n";
					$oldKeyPos[] = $keyPos;
					$oldSquares[] = $squares;
					$oldColumns[] = $columns;
					$oldLines[] = $lines;
					$oldRes[] = $res;
					$valeurChoisie = $pos[$keyPos][0];
					echo "break1 $keyPos => {$pos[$keyPos][0]}\n";
					unset($pos[$keyPos][0]);
					$oldPos[] = $pos[$keyPos];
					if ($keyPos == 0) {
						$res = $valeurChoisie . substr($res, $keyPos + 1);
					} else {
						$res = substr($res, 0, $keyPos) . $valeurChoisie . substr($res, $keyPos + 1);
					}
					if (strlen($res) != 81) {
						echo "too long1\n";
					}
					$l = MyFonctions::getLineFromOffset($keyPos);
					$c = MyFonctions::getColumnFromOffset($keyPos);
					$s = MyFonctions::getSquare($l, $c);
					$posS = MyFonctions::getPositionInSquare($l, $c);
					$squares[$s][$posS] = $valeurChoisie;
					$columns[$c][$l] = $valeurChoisie;
					$lines[$l][$c] = $valeurChoisie;
				}
			} else {
				echo "old != res\n";
				$old = $res;
				$pos = [];
				$firstPos = strpos($res, '-');
				$lastPos = strrpos($res, '-');
				for ($offsetCar = $firstPos; $offsetCar <= $lastPos; $offsetCar++) {
					if (substr($res, $offsetCar, 1) == '-') {
						$pos[$offsetCar] = [];
						for ($val = 1; $val <= 9; $val++) {
							$l = MyFonctions::getLineFromOffset($offsetCar);
							if (!in_array($val, $lines[$l])) {
								$c = MyFonctions::getColumnFromOffset($offsetCar);
								$s = MyFonctions::getSquare($l, $c);
								if (!in_array($val, $squares[$s])) {
									if (!in_array($val, $columns[$c])) {
										$pos[$offsetCar][] = $val;
									}
								}
							}
						}
						if (count($pos[$offsetCar]) == 1 && $pos[$offsetCar][0] !== null) {
							echo "unique value $offsetCar {$pos[$offsetCar][0]}\n";
							if ($offsetCar == 0) {
								$res = $pos[$offsetCar][0] . substr($res, $offsetCar + 1);
							} else {
								$res = substr($res, 0, $offsetCar) . $pos[$offsetCar][0] . substr($res, $offsetCar + 1);
							}
							if (strlen($res) != 81) {
								echo "too long2\n";
							}
							$posS = MyFonctions::getPositionInSquare($l, $c);
							$squares[$s][$posS] = $pos[$offsetCar][0];
							$columns[$c][$l] = $pos[$offsetCar][0];
							$lines[$l][$c] = $pos[$offsetCar][0];
						} elseif (count($pos[$offsetCar]) == 0) {
							echo "no value $offsetCar\n";
							$pos = [];
							// if faut revenir en arrière sur le dernier choix
							$indexPos = count($oldPos) - 1;
							if ($indexPos !== null && $indexPos >= 0) {
								if (count($oldPos[$indexPos]) > 0) {
									$oldPosIndexPosIndexPosKey = array_pop($oldPos[$indexPos]);
									$lastKey = $oldKeyPos[$indexPos];
									if ($lastKey === null) {
										echo "break2\n";
										break;
									}
									$l = MyFonctions::getLineFromOffset($lastKey);
									$c = MyFonctions::getColumnFromOffset($lastKey);
									$s = MyFonctions::getSquare($l, $c);
									$posS = MyFonctions::getPositionInSquare($l, $c);

									$res = $oldRes[$indexPos];
									$squares = $oldSquares[$indexPos];
									$columns = $oldColumns[$indexPos];
									$lines = $oldLines[$indexPos];
									if (count($oldPos[$indexPos]) == 0) {
										array_pop($oldPos);
										array_pop($oldKeyPos);
										array_pop($oldSquares);
										array_pop($oldColumns);
										array_pop($oldLines);
										array_pop($oldRes);
									}
									$squares[$s][$posS] = $oldPosIndexPosIndexPosKey;
									$columns[$c][$l] = $oldPosIndexPosIndexPosKey;
									$lines[$l][$c] = $oldPosIndexPosIndexPosKey;
									echo "new value $lastKey $oldPosIndexPosIndexPosKey\n";
									if ($lastKey == 0) {
										$res = $oldPosIndexPosIndexPosKey . substr($res, $lastKey + 1);
									} else {
										$res = substr($res, 0, $lastKey) . $oldPosIndexPosIndexPosKey . substr($res, $lastKey + 1);
									}
									if (strlen($res) != 81) {
										echo "too long3\n";
									}
								}
							}
							echo "break3\n";
							break;
						}
					}
				}
			}
			$count++;
		}

		return $res;
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