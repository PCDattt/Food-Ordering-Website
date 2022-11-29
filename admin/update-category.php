<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>

        <?php
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
                $sql ="SELECT * FROM category WHERE id=$id";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);

                if($count == 1)
                {
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $c_image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else
                {
                    $_SESSION['no-category-found'] = "<div class='error'>Category Not Found</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            }
            else
            {
                header('location:'.SITEURL.'admin/manage-category.php');
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbn-30">
                <tr>
                    <td>Title</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title;?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image</td>
                    <td>
                        <?php
                            if($c_image_name != "")
                            {
                                ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $c_image_name; ?>" width="150px">
                                <?php
                            }
                            else
                            {
                                echo "<div class='error'>Image not Added</div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured</td>
                    <td>
                        <input <?php if($featured=="Yes") echo "checked";?> type="radio" name="featured" value="Yes">Yes
                        
                        <input <?php if($featured=="No") echo "checked";?> type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active</td>
                    <td>
                        <input <?php if($active=="Yes") echo "checked";?> type="radio" name="active" value="Yes">Yes
                        
                        <input <?php if($active=="No") echo "checked";?> type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type='hidden' name="c_image_name" value ="<?php echo $c_image_name; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
        
        <?php 
            if(isset($_POST['submit']))
            {
                $id = $_POST['id'];
                $title = $_POST['title'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];
                $c_image_name = $_POST['c_image_name'];

                if(isset($_FILES['image']['name']))
                {
                    $image_name = $_FILES['image']['name'];
                    if($image_name != "")
                    {
                        //Auto rename image
                        //Get extension
                        $ext = end(explode('.', $image_name));
                        //Rename image
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext;

                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/category/".$image_name;

                        $upload = move_uploaded_file($source_path, $destination_path);

                        if($upload==false)
                        {
                            $_SESSION['update'] = "<div class='error'>Failed to Update Image</div>";
                            header('location:'.SITEURL.'admin/manage-category.php');
                            die();
                        }

                        if($c_image_name != "")
                        {

                            $remove_path = "../images/category/".$c_image_name;

                            $remove = unlink($remove_path);

                            if(! $remove)
                            {
                                $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Image</div>";
                                header('location:'.SITEURL.'admin/manage-category.php');
                                die();
                            }

                        }
                    }
                    else
                    {
                        $image_name = $c_image_name;
                    }
                    
                }
                else
                {
                    $image_name = $c_image_name;
                }

                $sql2 = "UPDATE category SET title='$title', image_name='$image_name', featured='$featured', active='$active' WHERE id=$id";

                $res2 = mysqli_query($conn, $sql2);

                if($res2)
                {
                    $_SESSION['update'] = "<div class='success'>Update Category Successfully</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    $_SESSION['update'] = "<div class='error'>Failed to Update Category</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            }
    ?>
    </div>

</div>
<?php include('partials/footer.php'); ?>