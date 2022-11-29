<?php

    include('../config/constants.php');

    $id = $_GET['id'];
    
    $sql = "DELETE FROM admin WHERE id = '$id'";

    $res = mysqli_query($conn, $sql) or die($conn);

    if($res)
    {
        //echo "Admin deleted";
        $_SESSION['delete'] = "<div class='success'>Admin deleted successfully</div>";
        header("location:".SITEURL.'admin/manage-admin.php');
    }
    else
    {
        //echo "Failed to delete admin";
        $_SESSION['delete'] = "<div class='error'>Failed to delete admin</div>";
        header("location:".SITEURL."admin/manage-admin.php");
    }
?>