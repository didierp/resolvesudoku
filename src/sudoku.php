<?php

include_once ('./MyFonctions.php');
$valid = false;
if (count($_REQUEST) == 81) {
	foreach ($_REQUEST as $item) {
		if ($item && $item >= 1 && $item <= 9) {
			$valid = true;
			break;
		}
	}
}
if ($valid) {
//	$grid = $argv[1];
	$grid = '---86---2-79-5-4--28-9--65-74-3--1-535--24-9---26-5--7--843-7--9--2--56-1-4--9-3-';
	$res = MyFunctions::getRes($grid);

	MyFunctions::displayGrid($res);
} else {
	?>
	<form name="sudokuform" method="post" action="sudoku.php">
		<table>
			<tr>
				<td><input type="text" id="0_0" name="0_0" value=""/></td>
				<td><input type="text" id="0_1" name="0_1" value=""/></td>
				<td><input type="text" id="0_2" name="0_2" value=""/></td>
				<td><input type="text" id="0_3" name="0_3" value=""/></td>
				<td><input type="text" id="0_4" name="0_4" value=""/></td>
				<td><input type="text" id="0_5" name="0_5" value=""/></td>
				<td><input type="text" id="0_6" name="0_6" value=""/></td>
				<td><input type="text" id="0_7" name="0_7" value=""/></td>
				<td><input type="text" id="0_8" name="0_8" value=""/></td>
			</tr>
			<tr>
				<td><input type="text" id="1_0" name="1_0" value=""/></td>
				<td><input type="text" id="1_1" name="1_1" value=""/></td>
				<td><input type="text" id="1_2" name="1_2" value=""/></td>
				<td><input type="text" id="1_3" name="1_3" value=""/></td>
				<td><input type="text" id="1_4" name="1_4" value=""/></td>
				<td><input type="text" id="1_5" name="1_5" value=""/></td>
				<td><input type="text" id="1_6" name="1_6" value=""/></td>
				<td><input type="text" id="1_7" name="1_7" value=""/></td>
				<td><input type="text" id="1_8" name="1_8" value=""/></td>
			</tr>
			<tr>
				<td><input type="text" id="2_0" name="2_0" value=""/></td>
				<td><input type="text" id="2_1" name="2_1" value=""/></td>
				<td><input type="text" id="2_2" name="2_2" value=""/></td>
				<td><input type="text" id="2_3" name="2_3" value=""/></td>
				<td><input type="text" id="2_4" name="2_4" value=""/></td>
				<td><input type="text" id="2_5" name="2_5" value=""/></td>
				<td><input type="text" id="2_6" name="2_6" value=""/></td>
				<td><input type="text" id="2_7" name="2_7" value=""/></td>
				<td><input type="text" id="2_8" name="2_8" value=""/></td>
			</tr>
			<tr>
				<td><input type="text" id="3_0" name="3_0" value=""/></td>
				<td><input type="text" id="3_1" name="3_1" value=""/></td>
				<td><input type="text" id="3_2" name="3_2" value=""/></td>
				<td><input type="text" id="3_3" name="3_3" value=""/></td>
				<td><input type="text" id="3_4" name="3_4" value=""/></td>
				<td><input type="text" id="3_5" name="3_5" value=""/></td>
				<td><input type="text" id="3_6" name="3_6" value=""/></td>
				<td><input type="text" id="3_7" name="3_7" value=""/></td>
				<td><input type="text" id="3_8" name="3_8" value=""/></td>
			</tr>
			<tr>
				<td><input type="text" id="4_0" name="4_0" value=""/></td>
				<td><input type="text" id="4_1" name="4_1" value=""/></td>
				<td><input type="text" id="4_2" name="4_2" value=""/></td>
				<td><input type="text" id="4_3" name="4_3" value=""/></td>
				<td><input type="text" id="4_4" name="4_4" value=""/></td>
				<td><input type="text" id="4_5" name="4_5" value=""/></td>
				<td><input type="text" id="4_6" name="4_6" value=""/></td>
				<td><input type="text" id="4_7" name="4_7" value=""/></td>
				<td><input type="text" id="4_8" name="4_8" value=""/></td>
			</tr>
			<tr>
				<td><input type="text" id="5_0" name="5_0" value=""/></td>
				<td><input type="text" id="5_1" name="5_1" value=""/></td>
				<td><input type="text" id="5_2" name="5_2" value=""/></td>
				<td><input type="text" id="5_3" name="5_3" value=""/></td>
				<td><input type="text" id="5_4" name="5_4" value=""/></td>
				<td><input type="text" id="5_5" name="5_5" value=""/></td>
				<td><input type="text" id="5_6" name="5_6" value=""/></td>
				<td><input type="text" id="5_7" name="5_7" value=""/></td>
				<td><input type="text" id="5_8" name="5_8" value=""/></td>
			</tr>
			<tr>
				<td><input type="text" id="6_0" name="6_0" value=""/></td>
				<td><input type="text" id="6_1" name="6_1" value=""/></td>
				<td><input type="text" id="6_2" name="6_2" value=""/></td>
				<td><input type="text" id="6_3" name="6_3" value=""/></td>
				<td><input type="text" id="6_4" name="6_4" value=""/></td>
				<td><input type="text" id="6_5" name="6_5" value=""/></td>
				<td><input type="text" id="6_6" name="6_6" value=""/></td>
				<td><input type="text" id="6_7" name="6_7" value=""/></td>
				<td><input type="text" id="6_8" name="6_8" value=""/></td>
			</tr>
			<tr>
				<td><input type="text" id="7_0" name="7_0" value=""/></td>
				<td><input type="text" id="7_1" name="7_1" value=""/></td>
				<td><input type="text" id="7_2" name="7_2" value=""/></td>
				<td><input type="text" id="7_3" name="7_3" value=""/></td>
				<td><input type="text" id="7_4" name="7_4" value=""/></td>
				<td><input type="text" id="7_5" name="7_5" value=""/></td>
				<td><input type="text" id="7_6" name="7_6" value=""/></td>
				<td><input type="text" id="7_7" name="7_7" value=""/></td>
				<td><input type="text" id="7_8" name="7_8" value=""/></td>
			</tr>
			<tr>
				<td><input type="text" id="8_0" name="8_0" value=""/></td>
				<td><input type="text" id="8_1" name="8_1" value=""/></td>
				<td><input type="text" id="8_2" name="8_2" value=""/></td>
				<td><input type="text" id="8_3" name="8_3" value=""/></td>
				<td><input type="text" id="8_4" name="8_4" value=""/></td>
				<td><input type="text" id="8_5" name="8_5" value=""/></td>
				<td><input type="text" id="8_6" name="8_6" value=""/></td>
				<td><input type="text" id="8_7" name="8_7" value=""/></td>
				<td><input type="text" id="8_8" name="8_8" value=""/></td>
			</tr>
		</table>
		<div>
			<input type="submit">
		</div>
	</form>
<?php }