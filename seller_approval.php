<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start session only if not already started
}

include("includes/db.php"); // Ensure correct database connection

if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {
?>

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / View Sellers
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-users fa-fw"></i> View Sellers
                </h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Seller Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Business Name</th>
                                <th>Address</th>
                                <th>Document</th>
                                <th>Status</th>
                                <th>Approve</th>
                                <th>Reject</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $get_sellers = "SELECT s.id, s.name, s.email, s.phone, s.status, d.business_name, d.address, d.document
                                            FROM sellers s
                                            LEFT JOIN seller_details d ON s.id = d.seller_id
                                            WHERE s.status = 'pending'";
                            $run_sellers = mysqli_query($con, $get_sellers);

                            while($row_sellers = mysqli_fetch_array($run_sellers)){
                                $seller_id = $row_sellers['id'];
                                $seller_name = $row_sellers['name'];
                                $seller_email = $row_sellers['email'];
                                $seller_phone = $row_sellers['phone'];
                                $seller_status = $row_sellers['status'];
                                $business_name = !empty($row_sellers['business_name']) ? $row_sellers['business_name'] : 'Not Available';
                                $address = !empty($row_sellers['address']) ? $row_sellers['address'] : 'Not Available';
                                $document = !empty($row_sellers['document']) ? "<a href='uploads/{$row_sellers['document']}' target='_blank'>View Document</a>" : 'Not Available';

                                $i++;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $seller_name; ?></td>
                                <td><?php echo $seller_email; ?></td>
                                <td><?php echo $seller_phone; ?></td>
                                <td><?php echo $business_name; ?></td>
                                <td><?php echo $address; ?></td>
                                <td><?php echo $document; ?></td>
                                <td><?php echo ucfirst($seller_status); ?></td>
                                <td>
                                    <a href="seller_approval.php?approve_seller=<?php echo $seller_id; ?>" class="btn btn-success">Approve</a>
                                </td>
                                <td>
                                    <a href="seller_approval.php?reject_seller=<?php echo $seller_id; ?>" class="btn btn-danger">Reject</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
}
?>
