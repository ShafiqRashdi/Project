<?php include('partials/menu.php'); ?>

        <!-- Main Content -->
        <div class="main-content">
            <div class="wrapper">
                <h1>Manage Admin Section</h1>

                <br />


                <?php 
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add'];//displaying session msg
                        unset($_SESSION['add']);//removing session msg
                    }

                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];//displaying session msg
                        unset($_SESSION['delete']);//removing session msg
                    }

                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];//displaying session msg
                        unset($_SESSION['update']);//removing session msg
                    }

                    if(isset($_SESSION['user-not-found']))
                    {
                        echo $_SESSION['user-not-found'];//displaying session msg
                        unset($_SESSION['user-not-found']);//removing session msg
                    }

                    if(isset($_SESSION['pwd-not-match']))
                    {
                        echo $_SESSION['pwd-not-match'];//displaying session msg
                        unset($_SESSION['pwd-not-match']);//removing session msg
                    }

                    if(isset($_SESSION['change-pwd']))
                    {
                        echo $_SESSION['change-pwd'];//displaying session msg
                        unset($_SESSION['change-pwd']);//removing session msg
                    }
                ?>
                <br><br><br>

                <!--Button add admin -->
                <a href="add-admin.php" class="btn-primary">Add Admin</a>

                <br /><br /><br />

                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Action</th>
                    </tr>

                    <?php
                        //query get all admin
                        $sql = "SELECT * FROM admin";
                        //execute query
                        $res = mysqli_query($conn, $sql);

                        //check whether the query is exequted or not
                        if($res==TRUE)
                        {
                            //count rows to check whether data in db or not
                            $count = mysqli_num_rows($res);//function to get all rows in db

                            $sn=1;//create the variable

                            //check the num of row
                            if($count>0)
                            {
                                //We have data in db
                                while($rows=mysqli_fetch_assoc($res))
                                {
                                    //using while loop to ghet all the data from db
                                    //and while loop will run as long we have data in db

                                    //get individual data
                                    $id=$rows['id'];
                                    $full_name=$rows['full_name'];
                                    $username=$rows['username'];

                                    //display the value in table
                                    ?>

                                        <tr>
                                            <td><?php echo $sn++; ?></td>
                                            <td><?php echo $full_name; ?></td>
                                            <td><?php echo $username; ?></td>
                                            <td>
                                            <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                            <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                            <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                                            </td>
                                        </tr> 

                                    <?php
                                }
                            }
                            else
                            {
                                //We dont have data in db
                            }
                        }
                    ?>

                    
                </table>

            </div>
        </div>
        <!-- Main Content End -->

        <?php include('partials/footer.php'); ?>