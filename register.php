<!DOCTYPE html>
<?php 
    include 'config.php';
    if (!isset($_SESSION['TradeUser'])) {
        include 'email-files.php';
        if (isset($_POST['register'])) {
            try {
                $name = $_POST['name'];
                $companyName = $_POST['companyName'];
                $cell = $_POST['cell'];
                $address = $_POST['address'];
                $email = $_POST['email'];
                $message = $_POST['message'];

                $mail->isHTML(true);
                $mail->clearAddresses();
                $mail->addAddress('arbu1499@gmail.com', 'Arbaz Ali');
                $mail->Subject = 'New Registration Request';
                $emailBody = "New Registration Request Submitted,<br><br>
                <strong>Details are:</strong><br>
                - Name: $name<br>
                - Company Name: $companyName<br>
                - Cell: $cell<br>
                - Address: $address<br>
                - Email: $email<br>
                - Message: $message<br><br>
                Thank you!";
                $mail->Body    = $emailBody;
                $mail->AltBody = strip_tags($emailBody);
                $mail->CharSet = 'UTF-8';
                $mail->send();

                $_SESSION['toastr_message'] = "Thank you for submitting the form, we will Respond you as soon as possible!";
                $_SESSION['toastr_type'] = "success";
                header("Location: register.php");
                exit();
            } catch (Exception $e) {
                $_SESSION['toastr_message'] = "An Unexpected Error Occured, Details are ".$e;
                $_SESSION['toastr_type'] = "error";
                header("Location: register.php");
                exit();
            }
        }
?>
<html lang="en">
    <head>
        <?php include 'header-files.php' ?>
        <title>Register | <?= $websiteName ?></title>
    </head>
    <body>
        <div class="wrapper-page">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <a href="javascript:void(0)" class="logo logo-admin"><img src="logo.png" height="80" alt="logo"></a>
                        <h6 class="m-t-10">Registration Form</h6>
                        <p>We would be delighted to serve you. Please fill out the form and we’ll get in touch with you shortly. You are important to us, and so is your information. We assure you that all information provided by you shall be treated with utmost confidentiality.</p>
                    </div>
                    <div class="p-3">
                        <form class="form-horizontal" action="" method="post">
                            <div class="form-group row">
                                <div class="col-6">
                                    <input name="name" class="form-control" type="text" required="" placeholder="Name">
                                </div>
                                <div class="col-6">
                                    <input name="companyName" class="form-control" type="text" required="" placeholder="Comapny Name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <input name="cell" class="form-control" type="text" required="" placeholder="Cell">
                                </div>
                                <div class="col-6">
                                    <input name="email" class="form-control" type="email" required="" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input name="address" class="form-control" type="text" required="" placeholder="Address">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <textarea name="message" class="form-control" aria-label="With textarea">Message</textarea>
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
                                    <button name="register" class="btn btn-primary btn-block waves-effect waves-light" type="submit">Register</button>
                                </div>
                            </div>
                            <div class="form-group m-t-10 mb-0 row">
                                <div class="col-sm-8 m-t-20">
                                    <!-- <a href="reset-password.php" class="text-muted"><i class="mdi mdi-lock"></i> <small>Forgot your Wachtwoord ?</small></a> -->
                                </div>
                                <div class="col-sm-4 m-t-20">
                                    <a href="login.php" class="text-muted"><small>Login to Account</small></a>
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