<?php
    //constants file
    include('../config/constants.php');
    //echo "delete";
    //check wether the id is set
    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //get value
        //echo "get value";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //remove image file
        if($image_name != "")
        {
            //image available
            $path = "../images/category/".$image_name;
            //remove image
            $remove = unlink($path);

            //if fail
            if($remove==false)
            {
                //set seeion msg
                $_SESSION['remove'] = "<div class='error'>Remove Category Image Failed</div>";
                //redirect to category page
                header('location:'.SITEURL.'admin/manage-category.php');
                //stop process
                die();
            }
        }

        //delete db
        //query delete data from db
        $sql = "DELETE FROM category WHERE id=$id";

        //execute the query
        $res = mysqli_query($conn, $sql);

        //check data deleted from db
        if($res==true)
        {
            //set success msg
            $_SESSION['delete'] = "<div class='success'>Category Deleted</div>";
            //redirect to manage category page
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            //set fail msg
            $_SESSION['delete'] = "<div class='error'>Category Delete Failed</div>";
            //redirect to manage category page
            header('location:'.SITEURL.'admin/manage-category.php');
        }

        

    }
    else
    {
        //redirect to category page
        header('location:'.SITEURL.'admin/manage-category.php');
    }
?>