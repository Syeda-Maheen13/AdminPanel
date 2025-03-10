<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include("includes/db.php"); // Adjust path if necessary

// Check if admin is logged in
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
    exit();
}
?>


    <div class="container" >
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" >
                        <i class="fa fa-dashboard"></i> Dashboard / View Users
                    </li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="fa fa-users fa-fw"></i> View Users
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Signup Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    $get_users = "SELECT * FROM users";
                                    $run_users = mysqli_query($con, $get_users);

                                    while ($row_users = mysqli_fetch_array($run_users)) {
                                        $user_id = $row_users['id'];
                                        $user_name = $row_users['name'];
                                        $user_email = $row_users['email'];
                                        $user_phone = $row_users['phone'];
                                        $created_at = $row_users['created_at'];
                                        $i++;
                                    ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $user_name; ?></td>
                                            <td><?php echo $user_email; ?></td>
                                            <td><?php echo $user_phone; ?></td>
                                            <td><?php echo $created_at; ?></td>
                                            <td>
                                            <a href="delete_user.php?delete_user=<?php echo $user_id; ?>" class="btn btn-danger btn-sm" >
    <i class="fa fa-trash"></i> Delete
</a>

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
    </div>


</body>
</html>