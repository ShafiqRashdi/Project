<?php 

    //include constants page
    include('../config/constants.php');

    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //process to delete
        //echo "process to delete";

        //get id and image name 
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //remove the image if availale
        if($image_name != "")
        {
            //if has image
            //get image path
            $path = "../images/food/".$image_name;

            //remove image file 
            $remove = unlink($path);

            //check whether the image ius remove
            if($remove==false)
            {
                //fail remove image
                $_SESSION['upload'] = "<div class='error'>Image Remove Failed</div>";
                //redirect to manage food page
                header('location:'.SITEURL.'admin/manage-food.php');
                //stop process
                die();
            }
        }

        //delete food from db
        $sql = "DELETE FROM food WHERE id=$id";
        //exeecute the query
        $res = mysqli_query($conn, $sql);

        //check whether query executed
        //redirect to manage food page
        if($res==true)
        {
            //food deletd
            $_SESSION['delete'] = "<div class='success'>Food Deleted</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            //delete fail
            //food deletd
            $_SESSION['delete'] = "<div class='error'>Food Delete Failed</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }

        
    }
    else
    {
        //redirect to manage food page
        //echo "process to ";
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorize Access</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }

?>