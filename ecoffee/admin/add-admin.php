<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Regiester Admin Section</h1>

        <br>

        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];//displaying session msg
                unset($_SESSION['add']);//removing session msg
            }
        ?>
        <br><br><br>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name</td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>
                </tr>

                <tr>
                    <td>UserName</td>
                    <td>
                        <input type="text" name="username" placeholder="Enter Your Username">
                    </td>
                </tr>

                <tr>
                    <td>Password</td>
                    <td>
                        <input type="password" name="password" placeholder="Enter Your Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>

<?php include('partials/footer.php') ?>

<?php
    //process the value form in db

    //1. get data
    if(isset($_POST['submit']))
    {
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = $_POST['password']; //password encryp with md5 md5($_POST['password'])

        //2. Query to save data into db
        $sql = "INSERT INTO admin SET
            full_name='$full_name',
            username='$username',
            password='$password'
        ";

        
        //3. executing query and send data to db
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        //4. check whether data is executed or not
        if($res==TRUE)
        {
            //echo "data inserted";
            //create variable to display msg
            $_SESSION['add'] = "<div class='success'>Admin added</div>";
            //redirect page to home
            header("location:".SITEURL.'admin/manage-admin.php');

        }
        else
        {
            //echo "data fail";
            //create variable to display msg
            $_SESSION['add'] = "<div class='error'>Add Admin Failed</div>";
            //redirect page to add admin page
            header("location:".SITEURL.'admin/add-admin.php');
        }
    }
    
    
?>