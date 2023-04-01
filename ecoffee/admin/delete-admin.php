<?php

    //include constant.php
    include('../config/constants.php');

    //1. get id from admin to delete
    $id = $_GET['id'];

    //2. create sql query to delete admin
    $sql = "DELETE FROM admin WHERE id=$id";

    //execute Query
    $res = mysqli_query($conn, $sql);

    //check whether the query executed succesfully
    if($res==TRUE)
    {
        //query executed succes
        //echo "Admin Deleted";
        //create session variable to display msg

        $_SESSION['delete'] = "<div class='success'>Admin Deleted</div>";
        //redirect to manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');

    }
    else
    {
        //fail to delete
        //echo "Admin fail Deleted";

        $_SESSION['delete'] = "<div class='error'>Admin Delete Failed</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }

    //3. redirect to manage admin page with msg
?>