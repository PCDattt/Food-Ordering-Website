<?php
    //Authorization - Access Control
    //Check user login or not
    if (! isset($_SESSION['user']))
    {
        $_SESSION['no-login-message'] = "<div class = 'error text-center' >Please Log In to access Admin Panel.</div>";
        header('location:'.SITEURL.'admin/login.php');
    }
    
?>