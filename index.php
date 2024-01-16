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
    } elseif (trim($line[0]) === "TYPE") {
        $type                = explode("  ", trim($line[1]));
        $row["TYPE"]["ID"]   = $type[0];
        $row["TYPE"]["NAME"] = $type[1];
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

var_dump($list);
