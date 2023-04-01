<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category Section</h1>

        <br><br>

        <?php

            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

        ?>

        <br><br>

        <!-- add category -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>

                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                    <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td coldspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <!-- add category end -->

        <?php

            //check whether submit button is click
            if(isset($_POST['submit']))
            {
                //echo "clicked";

                //get value from form
                $title = $_POST['title'];

                //check radio input click
                if(isset($_POST['featured']))
                {
                    //get the value from form
                    $featured = $_POST['featured'];
                }
                else
                {
                    //set the default value
                    $featured = 'No';
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = 'No';
                }

                //check whether the image is selcted
                //print_r($_FILES['image']);

                //die();//break the code

                if(isset($_FILES['image']['name']))
                {
                    //upload image
                    $image_name = $_FILES['image']['name'];

                    //upload image on selected
                    if($image_name != "")
                    {

                        //upload image
                        //image name
                        $image_name = $_FILES['image']['name'];

                        //auto rename image
                        //get image extension
                        $ext = end(explode('.', $image_name));

                        //rename image
                        $image_name = "food_category_".rand(000, 999).'.'.$ext;

                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/category/".$image_name;

                        //finally upload image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //check whther the image is uploaded
                        //if the image not uploaded
                        if($upload==false)
                        {
                            //set msg
                            $_SESSION['upload'] = "<div class='error'>Image Upload Failed</div>";
                            //redirect to add category page
                            header('location:'.SITEURL.'admin/add-category.php');
                            //stop the process
                            die();
                        }
                    }
                }
                else
                {
                    //upload fail
                    $image_name = "";
                }

                // create sql query to insert category into db
                $sql = "INSERT INTO category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                ";

                //execute the query
                $res = mysqli_query($conn, $sql);

                //check whether the query executed or not
                if($res==true)
                {
                    //query executed
                    $_SESSION['add'] = "<div class='success'>Category Added</div>";
                    //redirect to manage page
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //query not executed
                    $_SESSION['add'] = "<div class='error'>Category Add Failed</div>";
                    //redirect to manage page
                    header('location:'.SITEURL.'admin/add-category.php');
                }
            }

        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>