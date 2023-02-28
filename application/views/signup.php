<?php $this->session->unset_userdata('userid'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url('asset/style.css'); ?>" type="text/css" media="all" />

</head>
<body>
    <?php include('navigation.php')?>
    <div class="header">
    <div class="left">
        <p>Create Account</p>
    </div>
    <div class="right">
    <form class="example" action="action_page.php">
  <input type="text" placeholder="Search.." name="search">
</form>
    </div>
</div>
  <div class="content">
    <div class="content-left">
        <h1>Sign Up</h1>
        <p>Create an account to submit tickets.
             read articles and engage in out community</p>
        <?php echo form_open('welcome/form'); ?>
         <input type="text" name="name" placeholder="Name" value=" <?php echo set_value('name'); ?>">
         <p name="nameerr"><?php echo form_error('name'); ?></p>
         <input type="email" name="email" placeholder="Email" value="<?php echo set_value('email'); ?>">
         <p name="emailerr"><?php echo form_error('email'); ?></p>
         <input type="password" name="password" placeholder="Password" >
         <p name="passworderr"><?php echo form_error('password'); ?></p>
         <input type="password" name="confirmpassword" placeholder="Confirm Password"> 
         <p name="cpassworderr"><?php echo form_error('confirmpassword'); ?></p>
         <input type="submit" name="submit" class="btn" value="submit">
         <input type="reset"  name="reset" class="btn" value="Discard">
        </form>   
    </div>
    <div class="content-right">
        <div class="user">
        
            <img src="<?php echo base_url('asset/img/avatar.png'); ?>">
            <div class="identity">
                <h3>Already a member? <a href="#signin">Sign In</a></h3>
                <p>To submit tickets, browse through articles ans participate in the community</p>
            </div>
        </div>
        <hr>
        <div class="admin">
            <img src="<?php echo base_url('asset/img/customer-service.png'); ?>">
            <div class="identity">
                <h3>Are you an Agent? <a href="<?php echo site_url('welcome/adminlogin') ?>">Login here</a></h3>
                <p>You will be taken to the agent interface</p>
            </div>
        </div>
    </div>
  </div>
</body>
</html>
