<?php include('../config/constants.php');
?>

<html>
    <head>
        <title>Login - ECOFFEE</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        
        <div class="login">
            <h1 class="text-center">Login</h1>
            <br><br>

            <?php
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            ?>
            <br><br>

            <!-- Login -->
            <form action="" method="POST" class="text-center">
                Username: <br>
                <input type="text" name="username" placeholder="Enter Username"><br><br>

                Password: <br>
                <input type="text" name="password" placeholder="Enter Password"><br><br>
                
                <input type="submit" name="submit" value="Login" class="btn-primary">
                <br><br>
            </form>
            <!-- Login End -->

            
        </div>

    </body>
</html>

<?php
    //check whether the submit work
    if(isset($_POST['submit']))
    {
        //process for login
        //get data from form
        $username = $_POST['username'];
        $password = $_POST['password'];

        //sql check whether the username and password exist
        $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";

        //execute sql
        $res = mysqli_query($conn, $sql);

        //count rows to check whether the user exist
        $count = mysqli_num_rows($res);

        if($count==1)
        {
            //user available
            $_SESSION['login'] = "<div class='success'>Login Successful</div>";
            $_SESSION['user'] = $username;//to check whether the user login

            //redirect to home page
            header('location:'.SITEURL.'admin/');
        }
        else
        {
            //user not available
            $_SESSION['login'] = "<div class='error text-center'>Login Unsuccessful</div>";
            //redirect to home page
            header('location:'.SITEURL.'admin/login.php');
        }

    }
?>