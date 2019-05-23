<?php
require "../../db/db.php";
require "../../notif/notif.php";
require "../../users/api/API.php";
session_start();
if (!isset($_SESSION['tmpadminname'])) {
    header("location:../login");
    exit();
}
$message = $_GET['message'];
$id = $_GET['id'];
$sql = "UPDATE `chat` SET `status` =1 WHERE `id` =:id";
$result = $connect->prepare($sql);
$result->bindvalue(":id", $id);
$result->execute();
$num = $result->execute();
$sqlp = "select * from chat where id=:id;";
$resultp = $connect->prepare($sqlp);
$resultp->bindvalue(":id", $id);
$resultp->execute();
$fetchp = $resultp->fetch(PDO::FETCH_ASSOC);
$a = "INSERT INTO `chat`( `id_user`, `text`, `date`, `status`, `direction`) VALUES (:id_user,:caption,:dat,1,1)";
$result = $connect->prepare($a);
$result->bindvalue(":id_user", $fetchp['id_user']);
$result->bindvalue(":caption", $message);
$result->bindvalue(":dat", date("Y/n/d-g:i:s a"));
$num = $result->execute();
if ($num) {
    header("location:../chat/?tip=802");
    exit();
} else {
    header("location:../chat/?error=926");
    exit();
}