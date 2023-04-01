<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order Section</h1>
        <br><br>

        <?php
        
            //check whether id is set
            if(isset($_GET['id']))
            {
                //get detail
                $id=$_GET['id'];

                //get all detail
                //sql query to get all detail
                $sql = "SELECT * FROM tbl_order WHERE id=$id";
                //execute query
                $res = mysqli_query($conn, $sql);
                //count row
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //available
                    $row=mysqli_fetch_assoc($res);

                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $status = $row['status'];
                }
                else
                {
                    //not available
                    //redirect 
                    header('location:'.SITEURL.'admin/update-order.php');
                }
            }
            else
            {
                //redirect to manage page
                header('location:'.SITEURL.'admin/update-order.php');
            }

        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Food Name</td>
                    <td><b><?php echo $food; ?><b></td>
                </tr>

                <tr>
                    <td>Price</td>
                    <td><b>RM<?php echo $price; ?><b></td>
                </tr>

                <tr>
                    <td>Qty</td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $qty; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status">
                            <option <?php if($status=="Ordered"){echo "selected";} ?> value="Ordered">Ordered</option>
                            <option <?php if($status=="On Delivery"){echo "selected";} ?> value="On Delivery">On Delivery</option>
                            <option <?php if($status=="Delivered"){echo "selected";} ?> value="Delivered">Delivered</option>
                            <option <?php if($status=="Canceled"){echo "selected";} ?> value="Canceled">Canceled</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td coldspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>

        <?php
            //check whether update click
            if(isset($_POST['submit']))
            {
                //echo "clicked";
                //get value from form
                $id = $_POST['id'];
                $price = $_POST['price'];
                $qty = $_POST['qty'];
                $total = $_POST['price'];
                $status = $_POST['status'];
                

                //update value
                $sql2 = "UPDATE tbl_order SET
                    qty = $qty,
                    total = $total,
                    status = '$status'
                    WHERE $id
                ";

                //execute query
                $res2 = mysqli_query($conn, $sql2);

                //cehck whether updated
                if($res2==true)
                {
                    //updated
                    $_SESSION['update'] = "<div class='success'>Order Updated</div>";
                    //redirect to manage order page
                    header('location:'.SITEURL.'admin/manage-order.php');
                }
                else
                {
                    //not update
                    $_SESSION['update'] = "<div class='error'>Order Update Failed</div>";
                    //redirect to manage order page
                    header('location:'.SITEURL.'admin/manage-order.php');
                }

                
            }
        ?>
        
    </div>
</div>

<?php include('partials/footer.php'); ?>