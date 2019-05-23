<?php
require "../db/db.php";
require "../users/api/API.php";
$who = $_COOKIE['tmpname'];
$transaction = $_GET['transaction'];
$amount = $_GET['amount'];
$sql = "select * from tmpuser where username=:user;";
$result = $connect->prepare($sql);
$result->bindvalue(":user", $who);
$result->execute();
$fetch = $result->fetch(PDO::FETCH_ASSOC);
if ($fetch['active'] == 0) {
    header("location:../unset");exit;
}
$transaction = $_GET['transaction'];
$a = "INSERT INTO `tmpaddmoney`( `id_user`, `amount`, `transaction`, `year`, `month`, `day`, `week`, `time`, `status`) VALUES (:id_user, :amount, :transaction, :year, :month, :day, :week, :time, 1)";
$result = $connect->prepare($a);
$result->bindvalue(":id_user", $fetch['id']);
$result->bindvalue(":amount", $amount);
$result->bindvalue(":transaction", $transaction);
$result->bindvalue(":year", date('Y'));
$result->bindvalue(":month", date('n'));
$result->bindvalue(":day", date("d"));
$result->bindvalue(":week", date('w'));
$result->bindvalue(":time", time());
$num = $result->execute();
if ($num){
    header('../account/?tip=816');
    exit();
}