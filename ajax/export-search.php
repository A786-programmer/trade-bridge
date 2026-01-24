<?php
include "../config.php";

// Form data fetch karo
$port          = $_POST['port'] ?? '';
$goods         = $_POST['goods'] ?? '';
$importer      = $_POST['importer'] ?? '';
$exporter      = $_POST['exporter'] ?? '';
$shippingLine  = $_POST['shippingLine'] ?? '';
$country       = $_POST['country'] ?? '';
$region        = $_POST['region'] ?? '';
$shipperName   = $_POST['shipperName'] ?? '';
$shipperAgent   = $_POST['shipperAgent'] ?? '';
$dischargePort   = $_POST['dischargePort'] ?? '';

$monthNames = ["january","february","march","april","may","june","july","august","september","october","november","december"];
$monthIndex = (int)date('n') - 1; 
$year = date('Y');

$table = "e_" . $monthNames[$monthIndex] . "_" . $year;

// Check karo ke table exist karta hai ya nahi
$tableExists = mysqli_query($con, "SHOW TABLES LIKE '$table'");
if(mysqli_num_rows($tableExists) == 0){
    echo "<tr><td colspan='11' class='text-center'>Latest month table ($table) not found.</td></tr>";
    exit;
}

// --- Dynamic WHERE conditions array ---
$where = ["1"]; // default 1 so that always valid

if ($port != "") {
    $where[] = "PORT LIKE '%".mysqli_real_escape_string($con, $port)."%'"; 
}
if ($goods != "") {
    $where[] = "GOODS LIKE '%".mysqli_real_escape_string($con, $goods)."%'"; 
}
if ($importer != "") {
    $where[] = "IMPORTER LIKE '%".mysqli_real_escape_string($con, $importer)."%'"; 
}
if ($exporter != "") {
    $where[] = "EXPORTER LIKE '%".mysqli_real_escape_string($con, $exporter)."%'"; 
}
if ($shippingLine != "") {
    $where[] = "SLINE LIKE '%".mysqli_real_escape_string($con, $shippingLine)."%'"; 
}
if ($country != "") {
    $where[] = "COUNTRY LIKE '%".mysqli_real_escape_string($con, $country)."%'"; 
}
if ($region != "") {
    $where[] = "REGION LIKE '%".mysqli_real_escape_string($con, $region)."%'"; 
}
if ($shipperName != "") {
    $where[] = "SHIPPER_NAME LIKE '%".mysqli_real_escape_string($con, $shipperName)."%'"; 
}
if ($shipperAgent != "") {
    $where[] = "SHIPPER_AGENT LIKE '%".mysqli_real_escape_string($con, $shipperAgent)."%'"; 
}
if ($dischargePort != "") {
    $where[] = "DISCHARGE_PORT LIKE '%".mysqli_real_escape_string($con, $dischargePort)."%'"; 
}

// Join all conditions with AND
$where_sql = implode(" AND ", $where);

// --- Final SQL ---
$sql = "SELECT 
            ID,
            SBDATE,
            EXPORTER,
            EXPADD,
            IMPORTER,
            IMPADD,
            SLINE,
            CONCAT(PORT,'<br>', COUNTRY ,'<br>', REGION) AS DEST,
            GRWT,
            QUANTITY,
            QTYUNIT,
            GOODS
        FROM $table
        WHERE $where_sql
        ORDER BY GRWT DESC";

// Debug SQL (sirf development ke liye)
echo "<!-- DEBUG SQL: $sql -->";

// Run query
$query = mysqli_query($con, $sql);
if (!$query) {
    echo "<tr><td colspan='11' class='text-danger text-center'>Database Error: ".mysqli_error($con)."</td></tr>";
    exit;
}

// Generate table rows
if (mysqli_num_rows($query) > 0) {
    $sn = 1;
    while ($row = mysqli_fetch_assoc($query)) {
        echo "<tr>
                <td>{$sn}</td>
                <td>".htmlspecialchars($row['SBDATE'])."</td>
                <td>".htmlspecialchars($row['EXPORTER'])."</td>
                <td>".htmlspecialchars($row['EXPADD'])."</td>
                <td>".htmlspecialchars($row['IMPORTER'])."</td>
                <td>".htmlspecialchars($row['IMPADD'])."</td>
                <td>".htmlspecialchars($row['SLINE'])."</td>
                <td>".htmlspecialchars($row['DEST'])."</td>
                <td>{$row['GRWT']}</td>
                <td>".htmlspecialchars($row['QUANTITY']).' '.htmlspecialchars($row['QTYUNIT'])."</td>
                <td>".htmlspecialchars($row['GOODS'])."</td>
              </tr>";
        $sn++;
    }
} else {
    echo "<tr><td colspan='11' class='text-center'>No Data Found</td></tr>";
}
