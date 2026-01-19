<?php
    $con = mysqli_connect('localhost','root','','trade_bridge');
    error_reporting(E_ALL);
    session_start();
    $currentDate = date('Y-m-d');
    $currentDateTime = date('Y-m-d h:i:s');  
    date_default_timezone_set('Asia/Karachi');
    $websiteName = 'TRADEBRIDGE';
    error_reporting(0);

    $user = mysqli_query($con,"SELECT * FROM users WHERE u_id = '$_SESSION[TradeUser]'");
    $fetchUser = mysqli_fetch_assoc($user);

    $hasAdminAccess = false;
    $canAccessImport = false;
    $canAccessExport = false;
    $canAccessBulkData = false;
    $canAccessAirFreightImport = false;
    $canAccessAirFreightExport = false;
    $canPrintImport = false;
    $canPrintExport = false;

    $hasPermission = mysqli_query($con,"SELECT * FROM user_permissions WHERE up_user = '$_SESSION[TradeUser]'");

    if (mysqli_num_rows($hasPermission) == 0 && $fetchUser['u_id'] == 1) {
        $hasAdminAccess = true;
    } else {
        while ($perm = mysqli_fetch_assoc($hasPermission)) {
            if ($perm['up_type'] === 'Import') {
                $canAccessImport = true;
                if ($perm['up_print'] == 1) {
                    $canPrintImport = true;
                }
            }
    
            if ($perm['up_type'] === 'Export') {
                $canAccessExport = true;
                if ($perm['up_print'] == 1) {
                    $canPrintExport = true;
                }
            }
        }
    } 
?>