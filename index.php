<?php
    include 'config.php';
    if (isset($_SESSION['TradeUser'])) {
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'header-files.php' ?>
        <title>Home | <?= $websiteName ?></title>
    </head>
    <body>
        <?php include 'header.php' ?>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            <h4 class="page-title">Settings</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'footer.php' ?>
    </body>
</html>
<?php
    } else {
        $_SESSION['toastr_message'] = "Invalid Access";
        $_SESSION['toastr_type'] = "error";
        header("Location: login.php");
        exit();
    }
?>