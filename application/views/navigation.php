
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="<?php echo base_url('asset/style.css'); ?>" type="text/css" media="all" />
</head>
<body>
    <nav class="navigation">
        <div class="left">
           <a href="<?php echo site_url('') ?>">
           <img src="<?php echo base_url('asset/img/serviceorg-normal.png'); ?>">
           <h2>AlmaShines</h2>
           </a>
           
        </div>
        <div class="right">
             <a href="<?php echo site_url('welcome/index') ?>">Home</a>
             <a href="<?php echo site_url('welcome/user') ?>">My Area</a>
             <a href="#">Knowledge Base</a>
             <a href="#">Community</a>
             <?php if($userid==0){?>
                <a href="<?php echo site_url('welcome/signin') ?>">Sign In</a> 
                <?php } else {?>
                <a href= "<?php echo site_url('welcome/signup') ?>">Log out</a>
                <?php } ?>
             <a href="<?php echo site_url('welcome/signup') ?>">Sign Up</a>
             <?php if($userid!=0&&$role==0){?>
             <a href="<?php echo site_url('welcome/ticket') ?>">Ticket</a>
             <?php } ?>
        </div>
    </nav>
    
</body>
</html>