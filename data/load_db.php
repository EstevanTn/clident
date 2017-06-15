<?php
$db = new PDO('sqlite:' . realpath(__DIR__) . '/clinica.db');
$fh = fopen(__DIR__ . '/query.sql', 'r');
while ($line = fread($fh, 4096)) {
    $db->exec($line);
}
fclose($fh);