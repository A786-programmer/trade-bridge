<?php
    $con = mysqli_connect('localhost','root','','trade_bridge');
    error_reporting(E_ALL);
    session_start();
    $currentDate = date('Y-m-d');
    $currentDateTime = date('Y-m-d h:i:s');  
    date_default_timezone_set('Asia/Karachi');
    $websiteName = 'TRADEBRIDGE';
    // error_reporting(0);

    $user = mysqli_query($con,"SELECT * FROM users WHERE u_id = '$_SESSION[TPUser]'");
    $fetchUser = mysqli_fetch_assoc($user);
?>