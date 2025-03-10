<?php
include("includes/db.php");

if (isset($_GET['delete_user'])) {
    $delete_id = intval($_GET['delete_user']); // Ensure it's an integer

    $delete_query = "DELETE FROM users WHERE id='$delete_id' LIMIT 1"; // Delete only one user
    $run_delete = mysqli_query($con, $delete_query);

    if ($run_delete) {
        echo "<script>alert('User Deleted Successfully!');</script>";
        echo "<script>window.location.href='index.php?user_mangement';</script>";
    } else {
        echo "<script>alert('Failed to Delete User');</script>";
    }
}
?>
