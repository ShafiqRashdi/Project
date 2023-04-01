<?php include('partials/menu.php'); ?>

<div class="maincontent">
    <div class="wrapper">
        <h1>Update Admin Section</h1>

        <br>

        <?php
            //1. get the id of selected admin
            $id=$_GET['id'];

            //2. create sql query to get details
            $sql="SELECT * FROM admin WHERE id=$id";

            //execute the query
            $res=mysqli_query($conn, $sql);

            //check wheter the query executed or not
            if($res==TRUE)
            {
                //check wheter the data is available
                $count = mysqli_num_rows($res);
                //check wheter we have admin data or not
                if($count==1)
                {
                    //get the details
                    //echo "Admin Available";
                    $row=mysqli_fetch_assoc($res);

                    $full_name = $row['full_name'];
                    $username = $row['username'];
                }
                else
                {
                    //redirect to manage admin page
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
            <tr>
                    <td>Full Name</td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>UserName</td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>

                <tr>
                    <td coldspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
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
        //echo "button clicked";
        //get all the values from form to update
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];

        //creat sql query to update admin
        $sql = "UPDATE admin SET
        full_name = '$full_name',
        username = '$username'
        WHERE id='$id'
        ";

        //execute query
        $res = mysqli_query($conn, $sql);

        //check whether query executed or not
        if($res==TRUE)
        {
            //query executed
            $_SESSION['update'] = "<div class='success'>Admin Updated</div>";
            //redioretc to manage admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
        else
        {
            //fail to executed
            $_SESSION['update'] = "<div class='error'>Admin Update Failed</div>";
            //redioretc to manage admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
    }
    
?>

<?php include('partials/footer.php'); ?>