<?php
// simple counter to test sessions. should increment on each page reload.
session_start();
$count = isset($_SESSION['count']) ? $_SESSION['count'] : 1;

echo $count;

$_SESSION['count'] = ++$count;
// check on the redis server
// docker-compose exec -it redis redis-cli keys \*
// docker-compose exec -it redis redis-cli ttl "PHPREDIS_SESSION:tldhl618hd50obcfgnofppp6r4"
?>
