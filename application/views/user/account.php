<!DOCTYPE html>
<html lang="en">
<head>
    <link href="" rel='stylesheet' type='text/css' />
</head>
<body>
<div class="container">
    <!-- validation -->
    <div class="grids">
        <div class="progressbar-heading grids-heading">
            <!--            <h2>User Account</h2>-->
            <!--            <img src="--><?// echo base_url();?><!-- assets/images/default_pic.jpg" height="250" width="200" alt="--><?// echo $user['name'];?><!--'s Profile" title="--><?// echo $user['name'];?><!--'s Profile"/>-->
        </div>
        <div class="forms-grids">
            <div class="forms3">
                <div class="w3agile-validation w3ls-validation">
                    <div class="panel panel-widget agile-validation register-form">
                        <div class="validation-grids widget-shadow" data-example-id="basic-forms">
                            <a href="<?php echo base_url(); ?>users/logout" class="logoutBtn">Logout</a>
                            <div class="input-info">
                                <h3>Welcome <?php echo $user['name']; ?>!</h3>
                            </div>
                            <div class="account-info">
                                <p><b>Name: </b><?php echo $user['name']; ?></p>
                                <p><b>Email: </b><?php echo $user['email']; ?></p>
                                <p><b>Phone: </b><?php echo $user['phone']; ?></p>
                                <p><b>Gender: </b><?php echo $user['gender']; ?></p>
                            </div>
                        </div>
                        <h1>Add Friends</h1>
                        <form action="<? echo base_url('users/addFriend');?>" method="post">
                            <input  type="submit" name="addfriend" value="Mitashi"/><p> Add as friend</p>
                            <input  type="submit" name="addfriend" value="Ravi"/><p>Add as friend</p>
                            <input  type="submit" name="addfriend" value="Vishakha"/><p>Add as friend</p>
                            <input  type="submit" name="addfriend" value="Vikram"/><p>Add as friend</p>
                            <input  type="submit" name="addfriend" value="Suyash"/><p>Add as friend</p>
                        </form>

                        <form action="<? echo base_url('users/getFriendsList');?>">
                            <input type="submit" name="list" value="LIST OF FRIENDS"/>
                        </form>

                    </div>
                </div>
                <div class="clear"> </div>
            </div>
        </div>
    </div>
    <!-- //validation -->
</div>
</body>
</html>


