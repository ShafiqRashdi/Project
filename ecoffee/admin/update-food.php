<?php include('partials/menu.php'); ?>

<?php
    //check whether id is set or not
    if(isset($_GET['id']))
    {
        //get all detail
        $id = $_GET['id'];

        //query to get selecteed food
        $sql2 = "SELECT * FROM food WHERE id=$id";
        //execute query
        $res2 = mysqli_query($conn, $sql2);

        //get value 
        $row2 = mysqli_fetch_assoc($res2);

        //get individual value
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
    }
    else
    {
        //redirect to manage food page
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food Section</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image:</td>
                    <td>
                    <?php
                        if($current_image == "")
                        {
                            //image available
                            echo "<div class='error'>Image Not Available</div>";
                        }
                        else
                        {
                            //image not avialble
                            ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                            <?php
                        }
                    ?>
                    </td>
                </tr>

                <tr>
                    <td>Select New image</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">

                            <?php
                                //query to get active category
                                $sql = "SELECT * FROM category WHERE active='Yes'";
                                //excute query
                                $res = mysqli_query($conn, $sql);
                                //count rows
                                $count = mysqli_num_rows($res);

                                //checl whether categoery available
                                if($count>0)
                                {
                                    //available
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        $category_title = $row['title'];
                                        $category_id = $row['id'];
                                        
                                        //echo "<option value='$category_id'>$category_title</option>";
                                        ?>
                                        <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title ?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    //not avaiable
                                    echo "<option value='0'>Category Not Available</option>";
                                }
                            ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured=="No") {echo "checked";} ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if($active=="Yes") {echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=="No") {echo "checked";} ?> type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php
        
            if(isset($_POST['submit']))
            {
                //echo "Button Clicked";

                //get all detail from form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];

                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //upload selected image 

                //check whether upload button clicked
                if(isset($_FILES['image']['name']))
                {
                    //clicked
                    $image_name = $_FILES['image']['name'];

                    //check whether file is available
                    if($image_name!="")
                    {
                        //Image available
                        //rename image
                        $ext = end(explode('.', $image_name));

                        $image_name = "Food-name-".rand(0000, 9999).'.'.$ext;

                        //get source path
                        $src_path = $_FILES['image']['tmp_name'];
                        $dest_path = "../images/food/".$image_name;

                        //upload image
                        $upload = move_uploaded_file($src_path, $dest_path);

                        //check whether image is uploaded
                        if($upload==false)
                        {
                            //upload fail
                            $_SESSION['upload'] = "<div class='error'>Upload Failed</div>";
                            //redirect to manage food page
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //stop process
                            die();
                        }

                        //remove current image
                        if($current_image!="")
                        {
                            //current image avilable
                            //remove image/
                            $remove_path = "../images/food/".$current_image;

                            $remove = unlink($remove_path);

                            //check whether image remove
                            if($remove==false)
                            {
                                //fail remove
                                $_SESSION['remove-failed'] = "<div class='error'>Remove Failed</div>";
                                //redirect to manage food page
                                header('location:'.SITEURL.'admin/manage-food.php');
                                //stop process
                                die();
                            }
                        }
                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }

                //update food in db
                $sql3 = "UPDATE food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                ";
 
                //execute query
                $res3 = mysqli_query($conn, $sql3);

                //check whether query executed
                if($res3==true)
                {
                    //query executed
                    $_SESSION['update'] = "<div class='success'>Food Updated</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //fail
                    $_SESSION['update'] = "<div class='success'>Food Updated</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                
                }

                
            }

        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>