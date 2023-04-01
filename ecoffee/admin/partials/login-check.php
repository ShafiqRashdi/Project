<?php
    //authorization acces control
    //check whether the user is login
    if(!isset($_SESSION['user']))
    {
        //user is not login
        //redirect to login page
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please Login to Admin Panel</div>";
        header('location:'.SITEURL.'admin/login.php');
    }
?>