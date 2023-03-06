<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url('asset/style.css'); ?>" type="text/css" media="all" />

</head>
<body>
    <?php include('navigation.php')?>
    <div class="header">
    <div class="left">
        <p>Home/Forget Password</p>
    </div>
    <div class="right">
    <form class="example" action="action_page.php">
  <input type="text" placeholder="Search.." name="search">
</form>
    </div>
</div>
<p class="err"> <?php echo $err ?></p>
<div class="content">
    <div class="content-left contentin-left">
        <h1>Already a Member</h1>
        <p>Enter your Email</p>
         
        <?php echo form_open('welcome/emailaunthitencate'); ?>
         <input type="email" name="email" placeholder="Email" value="<?php echo $flag=false ? $email :'' ?>">
         <p name="emailerr"><?php echo form_error('email'); ?></p>
         <input type="submit" name="submit" class="btn" value="submit">
        </form>   
    </div>
    <div class="content-right contentin-right">
        <div class="user">
            <img src="<?php echo base_url('asset/img/avatar.png'); ?>">
            <div class="identity">
                <h3>Already a member? <a href="<?php echo site_url('welcome/signin') ?>">Sign In</a></h3>
                <p>To submit tickets, browse through articles ans participate in the community</p>
            </div>
        </div>
    <hr>
    <div class="admin">
            <img src= "<?php echo base_url('asset/img/customer-service.png'); ?>">
            <div class="identity">
                <h3>Are you an Agent? <a href="<?php echo site_url('welcome/adminlogin') ?>">Login here</a></h3>
                <p>You will be taken to the agent interface</p>
            </div>
        </div>
    </div>
  </div>
</body>
</html>