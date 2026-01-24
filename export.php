<?php
    include 'config.php';
    if (isset($_SESSION['TradeUser'])) {
        if (!$canAccessExport) {
            $_SESSION['toastr_message'] = "Invalid Access";
            $_SESSION['toastr_type'] = "error";
            header("Location: index.php");
            exit();
        }
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body"> 
                                <h4 class="mt-0 header-title">Export</h4>                      
                                <form id="exportSearchForm">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label>Port Of Shipping</label>
                                            <select class="form-control" name="port">
                                                <option value="">---ALL---</option>
                                                <option value="Karachi">Karachi</option>
                                                <option value="Port Qasim">Port Qasim</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Vessel Name</label>
                                            <input type="text" class="form-control" name="vessels">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Goods Description</label>
                                            <input type="text" class="form-control" name="goods">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Importer Name</label>
                                            <input type="text" class="form-control" name="importer">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Shipper Name</label>
                                            <input type="text" class="form-control" name="shipperName">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Shipper Agent</label>
                                            <input type="text" class="form-control" name="shipperAgent">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Shipping Line</label>
                                            <input type="text" class="form-control" name="shippingLine">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Discharge Port</label>
                                            <input type="text" class="form-control" name="dischargePort">
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label>Country</label>
                                            <input type="text" class="form-control" name="country">
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label>Region</label>
                                            <input type="text" class="form-control" name="region">
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <button type="submit" class="btn btn-primary">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">Export Data</h4>  
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Sb Date</th>
                                            <th>Export</th>
                                            <th>Expoter Address</th>
                                            <th>Importer</th>
                                            <th>Importer Address</th>
                                            <th>Shipping Line</th>
                                            <th>Dest Port Country Region</th>
                                            <th>GRWT (Mt)</th>
                                            <th>Quantity/Qtyunit</th>
                                            <th>Goods</th>
                                        </tr>
                                    </thead>
                                    <tbody id="exportTableBody">
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
<script>
    $("#exportSearchForm").on("submit", function (e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: "ajax/export-search.php",
            type: "POST",
            data: formData,
            success: function (response) {
                // sirf tbody update karo
                $("#exportTableBody").html(response);
            },
            error: function (xhr, status, error) {
                $("#exportTableBody").html(
                    "<tr><td colspan='11' class='text-danger text-center'>Error loading data: " + error + "</td></tr>"
                );
            }
        });
    });
</script>
<?php
    } else {
        $_SESSION['toastr_message'] = "Invalid Access";
        $_SESSION['toastr_type'] = "error";
        header("Location: login.php");
        exit();
    }
?>