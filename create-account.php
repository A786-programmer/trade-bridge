<?php
    include 'config.php';
    if (isset($_SESSION['TradeUser'])) {
        if (isset($_POST['create'])) {
            try {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $clientip1 = $_POST['clientip1'];
                $clientip2 = $_POST['clientip2'];
                $clientip3 = $_POST['clientip3'];
                $clientip4 = $_POST['clientip4'];
                $company = $_POST['company'];
                $telephone = $_POST['telephone'];
                $address = $_POST['address'];

                $addUser = mysqli_query($con, "INSERT INTO `users` (u_username, u_password, u_name, u_company, u_address, u_telephone, u_email, u_client_ip_1, u_client_ip_2, u_client_ip_3, u_client_ip_4) 
                VALUES ('$username', '$password', '$name', '$company', '$address', '$telephone', '$email', '$clientip1', '$clientip2', '$clientip3', '$clientip4')");

                if ($addUser) {
                    $userId =$con->insert_id;
                    $importavailability = $_POST['importavailability'];
                    if ($importavailability) {
                        $print = isset($_POST['importprint']) ? '1' : '0';
                        $importfrom = $_POST['importfrom'];
                        $importil = $_POST['importil'];
                        mysqli_query($con, "INSERT INTO `user_permissions` (up_type, up_from, up_till, up_print, up_user) 
                        VALUES ('Import', '$importfrom', '$importil', '$print', '$userId')");
                    }

                    $exportavailability = $_POST['exportavailability'];
                    if ($exportavailability) {
                        $print = isset($_POST['exportprint']) ? '1' : '0';
                        $exportfrom = $_POST['exportfrom'];
                        $exportil = $_POST['exportil'];
                        mysqli_query($con, "INSERT INTO `user_permissions` (up_type, up_from, up_till, up_print, up_user) 
                        VALUES ('Export', '$exportfrom', '$exportil', '$print', '$userId')");
                    }
                }

                $_SESSION['toastr_message'] = "New User Account Created Successfully!";
                $_SESSION['toastr_type'] = "success";
                header("Location: create-account.php");
                exit();
            } catch (Exception $e) {
                $_SESSION['toastr_message'] = "Encountered an Error, Details are ". $e;
                $_SESSION['toastr_type'] = "error";
                header("Location: create-account.php");
                exit();
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'header-files.php' ?>
        <title>Create Account | <?= $websiteName ?></title>
    </head>
    <body>
        <?php include 'header.php' ?>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            <h4 class="page-title">User Accounts</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body"> 
                                <h4 class="mt-0 header-title">Create An Account</h4>                      
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <!-- Row 1 -->
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Name</label>
                                            <input required type="text" class="form-control" name="name"/>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">E-mail</label>
                                            <input required type="email" class="form-control" name="email"/>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Username</label>
                                            <input required type="text" class="form-control" name="username"/>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Password</label>
                                            <input required type="text" class="form-control" name="password"/>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Client IP 1</label>
                                            <input required type="text" class="form-control" name="clientip1"/>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Client IP 2</label>
                                            <input required type="text" class="form-control" name="clientip2"/>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Client IP 3</label>
                                            <input required type="text" class="form-control" name="clientip3"/>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Client IP 4</label>
                                            <input required type="text" class="form-control" name="clientip4"/>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Company</label>
                                            <input required type="text" class="form-control" name="company"/>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Telephone</label>
                                            <input required type="text" class="form-control" name="telephone"/>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="input-title">Address</label>
                                            <input required type="text" class="form-control" name="address"/>
                                        </div>
                                    </div>
                                    <h4><b>Permissions</b></h4>
                                    <div class="row">
                                        <div class="col-md-2 mb-3">
                                            <label class="input-title">Import</label>
                                            <div class="custom-control custom-checkbox">
                                                <input name="importavailability" value="ida" type="checkbox" class="custom-control-input" id="customCheck1" data-parsley-multiple="groups" data-parsley-mincheck="2">
                                                <label class="custom-control-label" for="customCheck1">Data Availability</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input name="importprint" value="idp" type="checkbox" class="custom-control-input" id="customCheck1" data-parsley-multiple="groups" data-parsley-mincheck="2">
                                                <label class="custom-control-label" for="customCheck1">Data Print</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">From</label>
                                            <input class="form-control" name="importfrom" type="month" value="" id="example-date-input">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Till</label>
                                            <input class="form-control" name="importil" type="month" value="" id="example-date-input">
                                        </div>
                                        <div class="col-md-4"></div>
                                        <div class="col-md-2 mb-3">
                                            <label class="input-title">Emport</label>
                                            <div class="custom-control custom-checkbox">
                                                <input name="exportavailability" value="eda" type="checkbox" class="custom-control-input" id="customCheck1" data-parsley-multiple="groups" data-parsley-mincheck="2">
                                                <label class="custom-control-label" for="customCheck1">Data Availability</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input name="exportprint" value="edp" type="checkbox" class="custom-control-input" id="customCheck1" data-parsley-multiple="groups" data-parsley-mincheck="2">
                                                <label class="custom-control-label" for="customCheck1">Data Print</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">From</label>
                                            <input class="form-control" name="exportfrom" type="month" value="" id="example-date-input">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Till</label>
                                            <input class="form-control" name="exportil" type="month" value="" id="example-date-input">
                                        </div>
                                        <div class="col-md-4"></div>
                                        <div class="col-md-12 text-start mt-3">
                                            <button type="submit" class="btn btn-primary" name="create">Create Account</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>                                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">User Accounts</h4>  
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Actions</th>
                                            <th>User ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Credentials</th>
                                            <th>Permissions</th>
                                            <th>Client IPs</th>
                                            <th>Company</th>
                                            <th>Telephone</th>
                                            <th>Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>XXX</td>
                                            <td>XXX</td>
                                            <td>XXX</td>
                                            <td>XXX</td>
                                            <td>XXX</td>
                                            <td>XXX</td>
                                            <td>XXX</td>
                                            <td>XXX</td>
                                            <td>XXX</td>
                                            <td>XXX</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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