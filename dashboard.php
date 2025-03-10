<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start session only if not already started
}

// Include database connection
include("includes/db.php"); // Adjust path if necessary

// Check if admin is logged in
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
    exit();
}

// Database Queries for Statistics
$stats = [
    [
        "query" => "SELECT COUNT(*) AS total FROM customers",
        "title" => "Customers",
        "icon" => "fa-comments",
        "color" => "panel-green",
        "link" => "index.php?view_customers"
    ],
    [
        "query" => "SELECT COUNT(*) AS total FROM product_categories",
        "title" => "Product Categories",
        "icon" => "fa-shopping-cart",
        "color" => "panel-yellow",
        "link" => "index.php?view_p_cats"
    ],
    [
        "query" => "SELECT COUNT(*) AS total FROM customer_orders",
        "title" => "Total Orders",
        "icon" => "fa-support",
        "color" => "panel-red",
        "link" => "index.php?view_orders"
    ],
    [
        "query" => "SELECT SUM(due_amount) AS total FROM customer_orders",
        "title" => "Earnings",
        "icon" => "fa-dollar",
        "color" => "panel-success",
        "link" => "index.php?view_orders"
    ],
    [
        "query" => "SELECT COUNT(*) AS total FROM pending_orders WHERE order_status = 'pending'",
        "title" => "Pending Orders",
        "icon" => "fa-spinner",
        "color" => "panel-warning",
        "link" => "index.php?view_orders"
    ],
    [
        "query" => "SELECT COUNT(*) AS total FROM customer_orders WHERE order_status = 'Complete'",
        "title" => "Completed Orders",
        "icon" => "fa-check",
        "color" => "panel-info",
        "link" => "index.php?view_orders"
    ]
];
?>

<div class="row">
    <?php foreach ($stats as $stat): ?>
        <?php
        $result = mysqli_query($con, $stat["query"]);
        $row = mysqli_fetch_assoc($result);
        $count = $row['total'] ?? 0; // Default to 0 if no result
        ?>
        <div class="col-lg-3 col-md-6">
            <div class="panel <?php echo $stat['color']; ?>">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa <?php echo $stat['icon']; ?> fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $count; ?></div>
                            <div><?php echo $stat['title']; ?></div>
                        </div>
                    </div>
                </div>
                <a href="<?php echo $stat['link']; ?>">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="row"><!-- 3 row Starts -->
    <div class="col-lg-12"><!-- col-lg-8 Starts -->
        <div class="panel panel-primary"><!-- panel panel-primary Starts -->
            <div class="panel-heading"><!-- panel-heading Starts -->
                <h3 class="panel-title"><!-- panel-title Starts -->
                    <i class="fa fa-money fa-fw"></i> New Orders
                </h3><!-- panel-title Ends -->
            </div><!-- panel-heading Ends -->

            <div class="panel-body"><!-- panel-body Starts -->
                <div class="table-responsive"><!-- table-responsive Starts -->
                    <table class="table table-bordered table-hover table-striped"><!-- table table-bordered table-hover table-striped Starts -->
                        <thead><!-- thead Starts -->
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Invoice No</th>
                                <th>Product ID</th>
                                <th>Qty</th>
                                <th>Size</th>
                                <th>Status</th>
                            </tr>
                        </thead><!-- thead Ends -->

                        <tbody><!-- tbody Starts -->
                            <?php
                            $i = 0;
                            $get_order = "select * from pending_orders order by 1 DESC LIMIT 0,5";
                            $run_order = mysqli_query($con, $get_order);

                            while ($row_order = mysqli_fetch_array($run_order)) {
                                $order_id = $row_order['order_id'];
                                $c_id = $row_order['customer_id'];
                                $invoice_no = $row_order['invoice_no'];
                                $product_id = $row_order['product_id'];
                                $qty = $row_order['qty'];
                                $size = $row_order['size'];
                                $order_status = $row_order['order_status'];
                                $i++;
                            ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <?php
                                        $get_customer = "select * from customers where customer_id='$c_id'";
                                        $run_customer = mysqli_query($con, $get_customer);

                                        if ($run_customer && mysqli_num_rows($run_customer) > 0) {
                                            $row_customer = mysqli_fetch_array($run_customer);
                                            $customer_email = $row_customer['customer_email'];
                                            echo $customer_email;
                                        } else {
                                            echo "N/A"; // Handle case where no data is found
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $invoice_no; ?></td>
                                    <td><?php echo $product_id; ?></td>
                                    <td><?php echo $qty; ?></td>
                                    <td><?php echo $size; ?></td>
                                    <td>
                                        <?php
                                        if ($order_status == 'pending') {
                                            echo $order_status = 'pending';
                                        } else {
                                            echo $order_status = 'Complete';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody><!-- tbody Ends -->
                    </table><!-- table table-bordered table-hover table-striped Ends -->
                </div><!-- table-responsive Ends -->

                <div class="text-right"><!-- text-right Starts -->
                    <a href="index.php?view_orders">
                        View All Orders <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div><!-- text-right Ends -->
            </div><!-- panel-body Ends -->
        </div><!-- panel panel-primary Ends -->
    </div><!-- col-lg-8 Ends -->
</div><!-- 3 row Ends -->