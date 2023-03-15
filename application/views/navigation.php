
<!DOCTYPE html>
<html lang="en" ng-app="myApp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <base href="<?php echo base_url("/index.php") ?>"/>
    <script src="https://code.angularjs.org/1.5.8/angular.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.18/angular-ui-router.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="<?php echo base_url("./application/asset/script.js") ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url("./application/asset/style.css") ?>" type="text/css" media="all" />
</head>
<body ng-controller="MyController">
    <nav class="navigation" ng-class="{1:'navigation-home', 0:''}[isHome]">
        <div class="left">
           <a ui-sref="home">
           <img ng-src="application/views/img/serviceorg-normal.png">
           <h2>AlmaShines</h2>
           </a>
        </div>
        <div class="right">
             <a ui-sref="home" ui-sref-active="active"  class="link">Home </a>
             <a ui-sref="users" ui-sref-active="active" class="link" ng-if="role === '0'" ng-hide="!userid">My Area</a>
             <a ui-sref="admin" ui-sref-active="active" class="link" ng-if="role === '1'" ng-hide="!userid">Admin Area</a>
             <a ui-sref="#" ui-sref-active="active" class="link">Knowledge Base</a>
             <a ui-sref="#" ui-sref-active="active" class="link">Community</a>
            <a ui-sref="signin" ui-sref-active="active" class="link" ng-show="uerid==='0' || !userid">Sign In</a> 
            <a ui-sref= "logout" ui-sref-active="active" class="link" ng-if= "userid !== 0" ng-hide="!userid">Log out</a>
             <a ui-sref="signup" ui-sref-active="active" class="link">Sign Up</a>
            <a ui-sref="ticket" ui-sref-active="active" class="link" ng-if= "userid !== '0' && role === '0' ">Ticket</a>
        </div>
    </nav>
    <div>
    <ui-view></ui-view>
    </div>

</body>
</html>
