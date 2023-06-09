<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food Section</h1>

        <br><br>

        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset ($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Title of The Food">
                    </td>
                </tr>

                <tr>
                    <td>Description</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Food Description"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">

                            <?php
                                //code to display category from db
                                //create sql to get all information
                                $sql = "SELECT * FROM category WHERE active='Yes'";

                                //execute query
                                $res = mysqli_query($conn, $sql);

                                //count rows
                                $count = mysqli_num_rows($res);

                                //if count>0 we have category
                                if($count>0)
                                {
                                    //have category
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        //get the categgory detail
                                        $id = $row['id'];
                                        $title = $row['title'];

                                        ?>

                                        <option value="1"<?php echo $id; ?>><?php echo $title; ?></option>

                                        <?php
                                    }
                                }
                                else
                                {
                                    //do not have category
                                    ?>
                                    <option value="0">No Category Found</option>
                                    <?php
                                    
                                }

                                //display
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td coldspan="2">
                    <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php

            //check whether button is click
            if(isset($_POST['submit']))
            {
                //add the food in db
                //echo "ddd";

                //get the data from form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                //check whether raio buton checked
                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else
                {
                    $featured = "No";
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No";
                }

                //upload image if selected
                //check whether select image clicked
                if(isset($_FILES['image']['name']))
                {
                    //get detail image
                    $image_name = $_FILES['image']['name'];
                    {
                        //check whether image is slected
                        if($image_name!="")
                        {
                            //image selected
                            //rename the image
                            //get extention of selected image
                            $ext = end(explode('.', $image_name));

                            //create new name for image
                            $image_name = "Food-Name-".rand(0000, 9999).".".$ext;

                            //upload the image
                            //get the source path and destination path

                            //source path is the current location
                            $src=$_FILES['image']['tmp_name'];

                            //get destination path for image
                            $dst = "../images/food/".$image_name;

                            //upload image 
                            $upload = move_uploaded_file($src, $dst);

                            //check whether image uploaded 
                            if($upload==false)
                            {
                                //fail to upload
                                //redirect to add food page
                                $_SESSION['upload'] = "<div class='error'>Image Upload Failed</div>";
                                header('location:'.SITEURL.'admin/add-food.php');
                                //stop process
                                die();
                            }
                        }

                    }
                }
                else
                {
                    $image_name = "";
                }

                //insert intoo db

                //creat sql query to save or add food
                $sql2 = "INSERT INTO food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category_id',
                    featured = '$featured',
                    active = '$active'
                ";

                //execute the query
                $res2 = mysqli_query($conn, $sql2);

                //redirect to manage food page
                //check whether data inserted

                if($res2 == true)
                {
                    //data inserted
                    $_SESSION['add'] = "<div class='success'>Food Added</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //data fail to insert
                    $_SESSION['add'] = "<div class='error'>Food Add Failed</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

                
            }

        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>