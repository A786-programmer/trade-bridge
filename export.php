<?php
    include 'config.php';
    if (isset($_SESSION['TradeUser'])) {
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'header-files.php' ?>
        <title>Export | <?= $websiteName ?></title>
    </head>
    <body>
        <?php include 'header.php' ?>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            <h4 class="page-title">Export</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body"> 
                                <h4 class="mt-0 header-title">Export</h4>                      
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Port Of shipping</label>
                                            <select required class="form-control" name="cargo_type">
                                                <option value="">---ALL---</option>
                                                <option value="LCL">LCL</option>
                                                <option value="FCL">FCL</option>
                                            </select>                                        
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Good Description</label>
                                            <input required type="text" class="form-control" name="password"/>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Importer Name</label>
                                            <input required type="text" class="form-control" name="clientip1"/>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Shipper Name</label>
                                            <input required type="text" class="form-control" name="clientip2"/>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Shipper Line</label>
                                            <input required type="text" class="form-control" name="clientip4"/>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Discharge</label>
                                            <input required type="text" class="form-control" name="company"/>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Country</label>
                                            <input required type="text" class="form-control" name="telephone"/>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="input-title">Region</label>
                                            <input required type="text" class="form-control" name="address"/>
                                        </div>
                                    </div>
                                        <div class="col-md-4"></div>
                                        <div class="col-md-12 text-start mt-3">
                                            <button type="submit" class="btn btn-primary" name="create">Search</button>
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
                                            <th>ID</th>
                                            <th>Sb Date</th>
                                            <th>Exporter</th>
                                            <th>Expoter Address</th>
                                            <th>Importer</th>
                                            <th>Importer Address</th>
                                            <th>Shipping Line</th>
                                            <th>Dest Port Country Region</th>
                                            <th>GRWT (Mt)</th>
                                            <th>Goods</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
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