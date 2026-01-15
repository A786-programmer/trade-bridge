<!DOCTYPE html>
<?php 
    include 'config.php';
    if (!isset($_SESSION['TradeUser'])) {
        if (isset($_POST['login'])) {
            try {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $account = mysqli_query($con, "SELECT * FROM `users` WHERE u_username = '$username' AND u_password = '$password'");
                if (mysqli_num_rows($account) == 0) {
                    $_SESSION['toastr_message'] = "Invalid Credentials!";
                    $_SESSION['toastr_type'] = "error";
                    header("Location: login.php");
                    exit();
                }
                $fetchAccount = mysqli_fetch_assoc($account);
                $_SESSION['TradeUser'] = $fetchAccount['u_id'];
                $_SESSION['toastr_message'] = "Successfully Logged In";
                $_SESSION['toastr_type'] = "success";
                header("Location: index.php");
                exit();
            } catch (Exception $e) {
                $_SESSION['toastr_message'] = "Encountered an Error, Details are ". $e;
                $_SESSION['toastr_type'] = "error";
                header("Location: login.php");
                exit();
            }
        }
?>
<html lang="en">
    <head>
        <?php include 'header-files.php' ?>
        <title>Login | <?= $websiteName ?></title>
    </head>
    <body>
        <div class="wrapper-page">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <a href="javascript:void(0)" class="logo logo-admin"><img src="logo.png" height="80" alt="logo"></a>
                    </div>
                    <div class="p-3">
                        <form class="form-horizontal" action="" method="post">
                            <div class="form-group row">
                                <div class="col-12">
                                    <input name="username" class="form-control" type="text" required="" placeholder="Username">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input name="password" class="form-control" type="password" required="" placeholder="Password">
                                </div>
                            </div>
                            <!-- <div class="form-group row">
                                <div class="col-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1">Remember me</label>
                                    </div>
                                </div>
                            </div> -->
                            <div class="form-group text-center row m-t-20">
                                <div class="col-12">
                                    <button name="login" class="btn btn-primary btn-block waves-effect waves-light" type="submit">Log In</button>
                                </div>
                            </div>
                            <div class="form-group m-t-10 mb-0 row">
                                <div class="col-sm-7 m-t-20">
                                    <!-- <a href="reset-password.php" class="text-muted"><i class="mdi mdi-lock"></i> <small>Forgot your Wachtwoord ?</small></a> -->
                                </div>
                                <div class="col-sm-5 m-t-20">
                                    <a href="register.php" class="text-muted"><small>Register an Account</small></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'footer.php' ?>
    </body>
</html>
<?php
    } else {
        $_SESSION['toastr_message'] = "You are already logged in!";
        $_SESSION['toastr_type'] = "info";
        header("Location: index.php");
        exit();
    }
?>