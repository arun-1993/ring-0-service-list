<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="style.css" />
		<title>Ring 0 Services</title>
	</head>

	<?php
		
	$list = [];
	$row  = [];

	exec("sc query type=kernel", $output);

	foreach ($output as $line) {
		$line = explode(":", $line);

		if (trim($line[0]) === "SERVICE_NAME") {
			$row["SERVICE_NAME"] = trim($line[1]);
		} elseif (trim($line[0]) === "DISPLAY_NAME") {
			$row["DISPLAY_NAME"] = trim($line[1]);
		} elseif (trim($line[0]) === "STATE") {
			$state                = explode("  ", trim($line[1]));
			$row["STATE"]["ID"]   = $state[0];
			$row["STATE"]["NAME"] = $state[1];
			array_push($list, $row);
			$row = [];
		} else {
			continue;
		}
	}
	
	?>

	<body>
		<div class="container">
		<h1>List of services running in Ring 0</h1>

		<table>
			<thead>
				<tr>
					<th>#</th>
					<th>Service Name</th>
					<th>Display Name</th>
					<th>State</th>
				</tr>
			</thead>

			<tbody>
				<?php for ($i = 0; $i < count($list); $i++): ?>
				<tr>
					<td><?php echo $i + 1; ?></td>
					<td><?php echo $list[$i]["SERVICE_NAME"]; ?></td>
					<td><?php echo $list[$i]["DISPLAY_NAME"]; ?></td>
					<td><?php echo $list[$i]["STATE"]["NAME"]; ?></td>
				</tr>
				<?php endfor;?>
			</tbody>
		</table>
		</div>
	</body>
</html>