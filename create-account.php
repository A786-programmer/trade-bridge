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

                $checkUser = mysqli_query($con, "SELECT u_id FROM users WHERE u_username = '$username'");

                if (mysqli_num_rows($checkUser) > 0) {
                    $_SESSION['toastr_message'] = "Username already exists!";
                    $_SESSION['toastr_type'] = "error";
                    header("Location: create-account.php");
                    exit();
                }

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
        if (isset($_POST['delete_user'])) {
            try {
                $userId = $_POST['user_id'];

                $deletePermissions = mysqli_query($con,"DELETE FROM user_permissions WHERE up_user = $userId");

                $deleteUser = mysqli_query($con,"DELETE FROM users WHERE u_id = $userId");
                $_SESSION['toastr_message'] = "User deleted successfully!";
                $_SESSION['toastr_type'] = "success";

            } catch (Exception $e) {

                $_SESSION['toastr_message'] = "Delete failed: " . $e->getMessage();
                $_SESSION['toastr_type'] = "error";
            }

            header("Location: create-account.php");
            exit();
        }
        $userID = isset($_GET['userID']) ? $_GET['userID'] : 0;
        $userQuery = mysqli_query($con, "SELECT * FROM users WHERE u_id='$userID'");
        if ($userID && mysqli_num_rows($userQuery) == 0) {
                $_SESSION['toastr_message'] = "Invalid Access!";
                $_SESSION['toastr_type'] = "error";
                header("Location: users.php");
                exit();
            }
        $fetchsuerData = mysqli_fetch_assoc($userQuery);
        $permQuery = mysqli_query($con, "SELECT * FROM user_permissions WHERE up_user='$userID'");
        $permissions = [];
        while ($p = mysqli_fetch_assoc($permQuery)) {
            $permissions[$p['up_type']] = $p;
        }

        // Handle update
        if (isset($_POST['update'])) {
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

            mysqli_query($con, "UPDATE users SET 
                u_name='$name',
                u_email='$email',
                u_username='$username',
                u_password='$password',
                u_company='$company',
                u_telephone='$telephone',
                u_address='$address',
                u_client_ip_1='$clientip1',
                u_client_ip_2='$clientip2',
                u_client_ip_3='$clientip3',
                u_client_ip_4='$clientip4'
                WHERE u_id='$userID'
            ");

            // Update permissions
            mysqli_query($con,"DELETE FROM user_permissions WHERE up_user='$userID'");

            if (isset($_POST['importavailability'])) {
                $print = isset($_POST['importprint']) ? '1' : '0';
                $importfrom = $_POST['importfrom'];
                $importil = $_POST['importil'];
                mysqli_query($con, "INSERT INTO `user_permissions` (up_type, up_from, up_till, up_print, up_user) 
                    VALUES ('Import', '$importfrom', '$importil', '$print', '$userID')");
            }

            if (isset($_POST['exportavailability'])) {
                $print = isset($_POST['exportprint']) ? '1' : '0';
                $exportfrom = $_POST['exportfrom'];
                $exportil = $_POST['exportil'];
                mysqli_query($con, "INSERT INTO `user_permissions` (up_type, up_from, up_till, up_print, up_user) 
                    VALUES ('Export', '$exportfrom', '$exportil', '$print', '$userID')");
            }

            $_SESSION['toastr_message'] = "User Updated Successfully!";
            $_SESSION['toastr_type'] = "success";
            header("Location: create-account.php");
            exit();
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
                                            <input  type="text" class="form-control" name="name" value="<?= htmlspecialchars($fetchsuerData['u_name']) ?>"/>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">E-mail</label>
                                            <input  type="email" class="form-control" name="email" value="<?= htmlspecialchars($fetchsuerData['u_email']) ?>"/>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Username</label>
                                            <input  type="text" class="form-control" name="username" value="<?= htmlspecialchars($fetchsuerData['u_username']) ?>"/>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Password</label>
                                            <input  type="text" class="form-control" name="password" value="<?= htmlspecialchars($fetchsuerData['u_password']) ?>"/>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Client IP 1</label>
                                            <input  type="text" class="form-control" name="clientip1" value="<?= htmlspecialchars($fetchsuerData['u_client_ip_1']) ?>"/>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Client IP 2</label>
                                            <input  type="text" class="form-control" name="clientip2" value="<?= htmlspecialchars($fetchsuerData['u_client_ip_2']) ?>"/>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Client IP 3</label>
                                            <input  type="text" class="form-control" name="clientip3" value="<?= htmlspecialchars($fetchsuerData['u_client_ip_3']) ?>"/>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Client IP 4</label>
                                            <input  type="text" class="form-control" name="clientip4" value="<?= htmlspecialchars($fetchsuerData['u_client_ip_4']) ?>"/>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Company</label>
                                            <input  type="text" class="form-control" name="company" value="<?= htmlspecialchars($fetchsuerData['u_company']) ?>"/>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Telephone</label>
                                            <input  type="text" class="form-control" name="telephone" value="<?= htmlspecialchars($fetchsuerData['u_telephone']) ?>"/>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="input-title">Address</label>
                                            <input  type="text" class="form-control" name="address" value="<?= htmlspecialchars($fetchsuerData['u_address']) ?>"/>
                                        </div>
                                    </div>
                                    <h4><b>Permissions</b></h4>
                                    <div class="row">
                                        <div class="col-md-2 mb-3">
                                            <label class="input-title">Import</label>
                                            <div class="custom-control custom-checkbox">
                                                <input name="importavailability" type="checkbox" class="custom-control-input" id="importAvailability" 
                                                <?php if(isset($permissions['Import'])) echo 'checked'; ?>>
                                                <label class="custom-control-label" for="importAvailability">Data Availability</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input name="importprint" type="checkbox" class="custom-control-input" id="importPrint"
                                                <?php if(isset($permissions['Import']) && $permissions['Import']['up_print'] == 1) echo 'checked'; ?>>
                                                <label class="custom-control-label" for="importPrint">Data Print</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">From</label>
                                            <input class="form-control" name="importfrom" type="month"
                                            value="<?= isset($permissions['Import']) ? htmlspecialchars($permissions['Import']['up_from']) : '' ?>">                                        
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Till</label>
                                            <input class="form-control" name="importil" type="month"
                                            value="<?= isset($permissions['Import']) ? htmlspecialchars($permissions['Import']['up_till']) : '' ?>">                                        
                                        </div>
                                        <div class="col-md-4"></div>
                                        <div class="col-md-2 mb-3">
                                            <label class="input-title">Export</label>

                                            <div class="custom-control custom-checkbox">
                                                <input name="exportavailability" type="checkbox" class="custom-control-input" id="exportAvailability"
                                                <?php if(isset($permissions['Export'])) echo 'checked'; ?>>
                                                <label class="custom-control-label" for="exportAvailability">Data Availability</label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input name="exportprint" type="checkbox" class="custom-control-input" id="exportPrint"
                                                <?php if(isset($permissions['Export']) && $permissions['Export']['up_print'] == 1) echo 'checked'; ?>>
                                                <label class="custom-control-label" for="exportPrint">Data Print</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">From</label>
                                            <input class="form-control" name="exportfrom" type="month"
                                            value="<?= isset($permissions['Export']) ? htmlspecialchars($permissions['Export']['up_from']) : '' ?>">                                        
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Till</label>
                                            <input class="form-control" name="exportil" type="month"
                                            value="<?= isset($permissions['Export']) ? htmlspecialchars($permissions['Export']['up_till']) : '' ?>">                                        
                                        </div>
                                        <div class="col-md-4"></div>
                                        <div class="col-md-12 text-start mt-3">
                                            <?php if ($userID) { ?>
                                            <button type="submit" name="update" class="btn btn-primary">Update User</button>
                                            <?php } else { ?>
                                            <button type="submit" class="btn btn-primary" name="create">Create Account</button>
                                            <?php } ?>
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
                                        <?php
                                            $sno = 1;
                                            $userQuery = mysqli_query($con,"
                                                SELECT 
                                                    u.u_id,
                                                    u.u_name,
                                                    u.u_email,
                                                    u.u_username,
                                                    u.u_company,
                                                    u.u_telephone,
                                                    u.u_address,
                                                    u.u_password,
                                                    u.u_client_ip_1,
                                                    u.u_client_ip_2,
                                                    u.u_client_ip_3,
                                                    u.u_client_ip_4,
                                                    GROUP_CONCAT(
                                                        CONCAT(
                                                            up.up_type,
                                                            ' (', up.up_from, ' - ', up.up_till, ')',
                                                            IF(up.up_print = 1, ' [Print]', '')
                                                        )
                                                        SEPARATOR '<br>'
                                                    ) AS permissions
                                                FROM users u
                                                LEFT JOIN user_permissions up 
                                                    ON up.up_user = u.u_id
                                                GROUP BY u.u_id
                                            ");
                                            while ($fetchUsers = mysqli_fetch_assoc($userQuery)) {
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="create-account.php?userID=<?= $fetchUsers['u_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                                <form method="post" style="display:inline;"
                                                    onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                    <input type="hidden" name="user_id" value="<?= $fetchUsers['u_id'] ?>">
                                                    <button type="submit" name="delete_user" class="btn btn-sm btn-danger">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>

                                            <td><?= $sno ?></td>
                                            <td><?= htmlspecialchars($fetchUsers['u_name']) ?></td>
                                            <td><?= htmlspecialchars($fetchUsers['u_email']) ?></td>

                                            <td>
                                                <strong>User:</strong> <?= htmlspecialchars($fetchUsers['u_username']) ?>
                                                <br><strong>Password:</strong> <?= htmlspecialchars($fetchUsers['u_password']) ?>
                                            </td>

                                            <td>
                                                <?= $fetchUsers['permissions'] ? $fetchUsers['permissions'] : 'No Permissions' ?>
                                            </td>

                                            <td>
                                                <?= $fetchUsers['u_client_ip_1'] ?><br>
                                                <?= $fetchUsers['u_client_ip_2'] ?><br>
                                                <?= $fetchUsers['u_client_ip_3'] ?><br>
                                                <?= $fetchUsers['u_client_ip_4'] ?>
                                            </td>

                                            <td><?= htmlspecialchars($fetchUsers['u_company']) ?></td>
                                            <td><?= htmlspecialchars($fetchUsers['u_telephone']) ?></td>
                                            <td><?= htmlspecialchars($fetchUsers['u_address']) ?></td>
                                        </tr>
                                        <?php 
                                                $sno++;
                                            }
                                        ?>
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