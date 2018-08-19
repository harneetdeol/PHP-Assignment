<?php
$db = new PDO('sqlite:' . realpath(__DIR__) . '/appointment.db');
$fh = fopen(__DIR__ . '/schema.sql', 'r');
while ($line = fread($fh, 12000)) {
    $db->exec($line);
}
fclose($fh);
?>