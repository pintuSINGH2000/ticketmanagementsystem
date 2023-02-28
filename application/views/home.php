<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url('asset/style.css'); ?>" type="text/css" media="all" />

</head>
<body>
<nav class="home-navigation">
    <div class="bar">
        <div class="left">
           <a href="<?php echo site_url('') ?>">
           <img src="<?php echo base_url('asset/img/serviceorg-normal.png'); ?>">
           <h2>AlmaShines</h2>
           </a>
        </div>
        <div class="right">
             <a href="<?php echo site_url('') ?>">Home</a>
             <a href="<?php echo site_url('welcome/user') ?>">My Area</a>
             <a href="#">Knowledge Base</a>
             <a href="#">Community</a>
             <?php if($userid==0){?>
                <a href="<?php echo site_url('welcome/signin') ?>">Sign In</a> 
                <?php } else {?>
                <a href= "<?php echo site_url('welcome/signin') ?>">Log out</a>
             <?php } ?>
             <a href="<?php echo site_url('welcome/signup') ?>">Sign Up</a>
             <?php if($userid!=0&&$role==0){?>
             <a href="<?php echo site_url('welcome/ticket') ?>">Ticket</a>
             <?php } ?>
        </div>
</div>
    <div class="home-header">
        <h1>Welcome to AlmaShines</h1>
        <p>search our knowledge base, ask the community or submit a ticket</p>
         <form class="example" action="action_page.php">
         <input type="text" placeholder="Search.." name="search">
         </form>
    </div>
</nav>
    <div class="home-content">
        <div class="content-1">
        <img src="<?php echo base_url('asset/img/folded-paper.png'); ?>">
        <a href="#knowledge Base">Knowledge Base</a>
        <p>Browse through our collection of articles, user guides and FAQs.</p>
        </div>
        <div class="content-2">
        <img src="<?php echo base_url('asset/img/chat.png'); ?>">
        <a href="#community">Community</a>
        <p>Ask questions, share ideas or start a discussion with other customers.</p>
        </div> 
        <div class="content-3">
        <img src="<?php echo base_url('asset/img/cinema-tickets.png'); ?>">
        <a href="#ticket">Tickets</a>
        <p>View your previous tickets; know their statuses and solutions.</p>
        </div> 
    </div>
    <div class="ticket-service">
        <h1><img src="<?php echo base_url('asset/img/briefcase.png'); ?>">Popular Article</h1>

        <h3><img src="<?php echo base_url('asset/img/page.png'); ?>">How to Add New Admins</h3>
        <h3><img src="<?php echo base_url('asset/img/page.png'); ?>"">Adding Faculity member to Alumni Portal</h3>
        <h3><img src="<?php echo base_url('asset/img/page.png'); ?>">How to use Import Data Feature</h3>
        <h3><img src="<?php echo base_url('asset/img/page.png'); ?>">From platform what type of emails are se...</h3>
        <h3><img src="<?php echo base_url('asset/img/page.png'); ?>">How to send birthday wish emails?</h3>
        <h3><img src="<?php echo base_url('asset/img/page.png'); ?>">Why I am Facing Email Deliverability Issues?</h3>
        <h3><img src="<?php echo base_url('asset/img/page.png'); ?>">What type of content should be created and shared on the alumni portal?</h3>
        <h3><img src="<?php echo base_url('asset/img/page.png'); ?>">Several Categories in Campus Feeds</h3>
    </div>
</body>
</html>
