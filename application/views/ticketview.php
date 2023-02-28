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
<div class="user-header">
    <img src="<?php echo base_url('asset/img/user.png'); ?>">
    <div class="user-detail">
        <h2>UserId</h2>
        <h2>UserName</h2>
    </div>
</div>
<div class="user-ticket">
    <table>
        <tr>
            <th>id</th>
            <th>UserId</th>
            <th>Subject</th>
            <th>Department</th>
            <th>Category</th>
            <th>Description</th>
            <th>File</th>
            <th>Status</th>
        </tr>
        
<?php foreach($tickets as $ticket) :?>
    
     <tr>
        <td><?php echo $ticket['id']?></td>
        <td><?php echo $ticket['userid']?></td>
        <td><?php echo $ticket['subject']?></td>
        <td><?php echo $ticket['department']?></td>
        <td><?php echo $ticket['category']?></td>
        <td><?php echo $ticket['description']?></td>
        <td><?php echo $ticket['file']?></td>
        <td><?php echo $ticket['status']?></td>
     </tr>
   <?php  endforeach?>
    </table>
    <p class="pagination"><?php echo $userlinks; ?></p>
</div>
</body>
</html>