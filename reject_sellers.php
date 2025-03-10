<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start session only if not already started
}

// Include database connection
include("includes/db.php"); // Adjust the path if necessary

// Check if admin is logged in
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
    exit();
}

// Check database connection
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / Rejected Sellers
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading bg-danger text-white">
                <h3 class="panel-title">
                    <i class="fa fa-times-circle fa-fw"></i> Rejected Sellers
                </h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <?php
                    $query = "SELECT s.id, s.name, s.email, s.phone, s.status, d.business_name, d.address, d.document
                              FROM sellers s
                              LEFT JOIN seller_details d ON s.id = d.seller_id
                              WHERE s.status = 'rejected'";

                    $result = mysqli_query($con, $query);

                    if (!$result) {
                        die("Query Failed: " . mysqli_error($con));
                    }

                    if (mysqli_num_rows($result) > 0) {
                        echo "<table class='table table-bordered table-hover table-striped'>
                                <thead class='bg-primary text-white'>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Business Name</th>
                                        <th>Address</th>
                                        <th>Document</th>
                                    </tr>
                                </thead>
                                <tbody>";

                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['phone']}</td>
                                    <td>" . (!empty($row['business_name']) ? $row['business_name'] : 'Not Available') . "</td>
                                    <td>" . (!empty($row['address']) ? $row['address'] : 'Not Available') . "</td>
                                    <td><a href='uploads/{$row['document']}' target='_blank'>View Document</a></td>
                                  </tr>";
                        }

                        echo "</tbody></table>";
                    } else {
                        echo "<div class='alert alert-warning text-center'>No rejected sellers found.</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
