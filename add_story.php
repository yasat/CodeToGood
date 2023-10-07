<?php
session_start();

unset($_SESSION['story_id']);

$data = json_decode(file_get_contents("php://input"));
$charecter = $data->char;
$sequence = $data->seq;

$con = mysqli_connect('localhost','root','','cfg') or die("connection failed");

$rows = mysqli_query($con, "select * from custom_stories");

$result = mysqli_num_rows($rows)+1;

mysqli_query($con, "insert into custom_stories values($result, '$charecter', '$sequence')");

echo $result;
?>