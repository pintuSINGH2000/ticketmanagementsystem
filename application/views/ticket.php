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
    <div class="ticket-left">
        <p><a href="signin.php">My Area &nbsp;</a>/ Submit a Ticket</p>
    </div>
    <div class="right">
    <form class="example" action="action_page.php">
  <input type="text" placeholder="Search.." name="search">
</form>
    </div>
</div>
   <div class="ticket-content">
    <div class="ticket-content-left">
        <div>
        <h1>Submit a ticket </h1>
        <p><b>Ticket Information</b></p>
        </div>
        <?php echo form_open_multipart('welcome/ticketValidation'); ?>
        <label for="subject">Subject <span>*</span><span><?php echo form_error('subject'); ?></span></label>
        <input type="text" name="subject">
        <label for="department">Department <span>*</span><span><?php echo form_error('department'); ?></span></label>
        <Select name="department" class="department">
            <option value="Onboarding">Onboarding</option>
            <option value="Sucess">Sucess</option>
            <option value="Support">Support</option>
            <option value="Accounts">Accounts</option>
        </Select>
        <label for="description">Description <span>*</span><span><?php echo form_error('description'); ?></span></label>
        <textarea id="description" name="description" rows="5" cols="50"></textarea>
        <label for="category">Priority </label>
        <Select name="category" class="category">
            <option value="">None</option>
            <option value="high">High</option>
            <option value="medium">Medium</option>
            <option value="low">Low</option>
        </Select>
        <div class="attachment">
        <label for="file">Attachment</label>
        <input type="file" name="file">
        <span></span>
        </div>
        <div class="ticket-btn">
         <input type="submit" name="submit" class="btn" value="submit">
         <input type="reset"  name="reset" class="btn" value="Discard">
        </div>
        </form>
    </div>
    <div class="ticket-content-right">
        <h1><img src="<?php echo base_url('asset/img/briefcase.png'); ?>">Popular Article</h1>
        <hr>
        <h3>How to Add New Admins</h3>
        <h3>Adding Faculity member to Alumni Portal</h3>
        <h3>How to use Import Data Feature</h3>
        <h3>From platform what type of emails are se...</h3>
        <h3>How to send birthday wish emails?</h3>
    </div>
   </div>
</body>
</html>