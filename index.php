<?php
$year = date("Y");
if (isset($_POST["year"]) && is_numeric($_POST["year"])) {
	$year = $_POST["year"];
}
$all_months = "";
for ($i = 1; $i <= 12; $i++) {
	$month = $i;
	$start_date = mktime(01, 00, 00, $month, 1, $year);
	$month_name = date("F", $start_date);
	$day_of_week = (int)date("w", $start_date);
	$start_date = $start_date - ($day_of_week * 86400); // start week from Sunday
	// Table head
	$head_start = $start_date;
	$table_head = "<tr>";
	for ($week_day = 1; $week_day <= 7; $week_day++) {
		$day_name = date("D", $head_start);
		$table_head = $table_head . "<th>$day_name</th>";
		$head_start = $head_start + 86400;
	}
	$table_head = $table_head . "</tr>";
	// 6 rows of table
	$week_number = 1;
	$table = "";
	while ($week_number <= 6) {
		// 7 cells of table row 
		$table = $table . "<tr>";
		for ($week_day = 1; $week_day <= 7; $week_day++) {
			$month_day = date("d", $start_date);
			// Day of previous or next month
			if (($week_number < 3 && (int)$month_day > 20) || ($week_number > 4 && (int)$month_day < 15)) {
				$table = $table . "<td class='off_month'>$month_day</td>";
			} else {
				// Day of this month
				$day_name = date("D", $start_date);
				if ($day_name == "Sun") {
					$table = $table . "<td class='weekend1'>$month_day</td>";
				} else if ($day_name == "Fri") {
					$table = $table . "<td class='weekend2'>$month_day</td>";
				} else {
					$table = $table . "<td>$month_day</td>";
				}
			}
			// Add 1 day for next cell
			$start_date = $start_date + 86400;
		}
		$table = $table . "</tr>";
		$week_number++;
	}
	$all_months .= "
		<div class='month'>
			<h2>$month_name $year</h2>
			<table>$table_head $table</table>
		</div>
		";
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Year Calendar - PHP</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="styles.css">
	</head>
	<body>
		<form id="year_form" method="post">
			Year <input id="year" name="year" type="number" value="<?php if (isset($year)) print $year; else print date("Y"); ?>" onchange="document.forms['year_form'].submit();" autofocus>
		</form>
		<main id="yearly_calendar">
			<?php print $all_months; ?>
		</main>
	</body>
</html>