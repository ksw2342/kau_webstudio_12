<?php

$botToken = "165696789:AAEufJINZF7p5Yi9PRgzFxDKBcYd-xPdPOM";
$website = "https://api.telegram.org/bot".$botToken;

$update = file_get_contents($website."/getupdates");

$updateArray = json_decode($update,TRUE);

$text = $updateArray["result"][0]["message"]["text"];

print_r( $updateArray);

?>
