<?php include('partials/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Change Password Section</h1>

            <br>

            <?php
                if(isset($_GET['id']))
                {
                    $id=$_GET['id'];
                }
            ?>

            <form action="" method="POST">

                <table class="tbl.30">
                    <tr>
                        <td>Current Password:</td>
                        <td>
                            <input type="password" name="current_password" placeholder="Current Password">
                        </td>
                    </tr>

                    <tr>
                        <td>New Password:</td>
                        <td>
                            <input type="password" name="new_password" placeholder="New Password">
                        </td>
                    </tr>

                    <tr>
                        <td>Confirm Password:</td>
                        <td>
                            <input type="password" name="confirm_password" placeholder="Confirm Password">
                        </td>
                    </tr>

                    <tr>
                        <td coldspan="2">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                        </td>
                    </tr>

                </table>

            </form>
        </div>
    </div>


<?php
    //check whether the submit button is click
    if(isset($_POST['submit']))
    {
        //echo "Clicked";

        //get the data from form
        $id=$_POST['id'];
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        //check whether user insert current id and password or not
        $sql = "SELECT * FROM admin WHERE id=$id AND password='$current_password'";

        //execute the query
        $res = mysqli_query($conn, $sql);

        if($res==TRUE)
        {
            //check whether data is available or not
            $count=mysqli_num_rows($res);

            if($count==1)
            {
                //user exist and password can change
                //echo "user Found";
                //check whether the new password and confirm match
                if($new_password==$confirm_password)
                {
                    //update the password
                    //echo "password match";
                    $sql2 = "UPDATE admin SET
                    password='$new_password'
                    WHERE id=$id
                    ";

                    //execute the query
                    $res2 = mysqli_query($conn, $sql2);

                    //check whether query executed
                    if($res2==true)
                    {
                        //display success msg
                        //redirect to manage admin page
                        $_SESSION['change-pwd'] = "<div class='success'>Password Changed </div>";
                        //redirect user
                        header("location:".SITEURL.'admin/manage-admin.php');
                    }
                    else
                    {
                        //display error msg
                        //redirect to manage admin page
                        $_SESSION['change-pwd'] = "<div class='error'>Change Password Failed </div>";
                        //redirect user
                        header("location:".SITEURL.'admin/manage-admin.php');
                    }
                }
                else
                {
                    //redirect to manage admin page
                    $_SESSION['pwd-not-match'] = "<div class='error'>Password Did not Match </div>";
                    //redirect user
                    header("location:".SITEURL.'admin/manage-admin.php');
                }
            }
            else
            {
                //user does not exist
                $_SESSION['user-not-found'] = "<div class='error'>User Not Found </div>";
                //redirect user
                header("location:".SITEURL.'admin/manage-admin.php');
            }
        }

        //check whether the confirm or new password match

        //change password if above true
    }
?>

<?php include('partials/footer.php'); ?>