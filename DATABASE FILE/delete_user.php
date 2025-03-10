<?php
if (isset($_GET['delete_user'])) {
    $user_id = $_GET['delete_user'];

    // Delete user from the database
    $delete_user = "DELETE FROM users WHERE id='$user_id'";
    $run_delete = mysqli_query($con, $delete_user);

    if ($run_delete) {
        echo "<script>alert('User has been deleted successfully!')</script>";
        echo "<script>window.open('index.php?view_users','_self')</script>";
    } else {
        echo "<script>alert('Error deleting user!')</script>";
    }
}
?>