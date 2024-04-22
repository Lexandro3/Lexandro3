<?php
global $connection;
$user = 'root';
$password = '';
$db = 'ev';

$db = mysqli_connect('localhost', $user, $password, $db) or die ('Nepodarilo sa pripojit');
?>
