<?php 
    include 'config.php';
    $request = $_GET['type'];
    if (!isset($_SESSION['TradeUser'])) {
        echo "<script>window.location='login.php';</script>";
    }
    switch($request){
        case "logout":
            unset($_SESSION["TradeUser"]);
            echo "<script>window.location='login.php';</script>";
        break;
        default:
            echo "<script>window.location='index.php';</script>";
        break;
    }
?>