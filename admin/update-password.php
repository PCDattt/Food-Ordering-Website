<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br/> <br/>

        <?php 
            $id = $_GET['id'];
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current Password</td>
                    <td><input type="password" name="c_pass" placeholder="Current Password"></td>
                </tr>
                
                <tr>
                    <td>New Password</td>
                    <td><input type="password" name="n_pass" placeholder="New Password"></td>
                </tr>

                <tr>
                    <td>Confirm Password</td>
                    <td><input type="password" name="cf_pass" placeholder="Confirm Password"></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Password" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
    </div>
</div>

<?php 
    if(isset($_POST['submit']))
    {
        $id = $_POST['id'];
        $c_pass = md5($_POST['c_pass']);
        $n_pass = md5($_POST['n_pass']);
        $cf_pass = md5($_POST['cf_pass']);

        $sql = "SELECT * FROM admin WHERE id = $id AND password = '$c_pass'";

        $res = mysqli_query($conn, $sql);

        if($res)
        {   
            $count = mysqli_num_rows($res);
            
            if($count == 1)
            {
                if($n_pass == $cf_pass)
                {
                    $sql2 = "UPDATE admin SET password = '$n_pass' WHERE id = $id";
                    $res2 = mysqli_query($conn, $sql2);
                    if($res2)
                    {
                        $_SESSION['change-pass'] = "<div class='success'>Change Password Successfully</div>";
                        header("location:".SITEURL.'admin/manage-admin.php');
                    }
                    else
                    {
                        $_SESSION['change-pass'] = "<div class='success'>Failed To Change Password</div>";
                        header("location:".SITEURL.'admin/manage-admin.php');
                    }
                }
                else
                {
                    $_SESSION['pw-not-match'] = "<div class='error'>Password Not Match</div>";
                    header("location:".SITEURL.'admin/manage-admin.php');
                }
            }
            else
            {
                $_SESSION['user-not-found'] = "<div class='error'>User Not Found</div>";
                header("location:".SITEURL.'admin/manage-admin.php');
            }
        }

    }
?>

<?php include('partials/footer.php'); ?>