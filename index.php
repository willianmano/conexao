<?php

require_once ('includes/Connection.php');

$con = Connection::getInstance();

$sql = "SELECT * FROM posts";
$data = array();

$res = $con->fetchAll($sql, $data);
echo "<pre>";
print_r($res);


$sql = "SELECT * FROM posts";
$data = array();

$res = $con->fetchAll($sql, $data);
echo "<pre>";
print_r($res);