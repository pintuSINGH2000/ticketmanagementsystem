var a="http://localhost/ticketmanagementsystem/index.php";
var b="http://localhost/ticketmanagementsystem";
console.log(window.location.href);
var myapp=angular.module("myApp",["ui.router"])
           .config(['$stateProvider','$urlMatcherFactoryProvider','$urlRouterProvider','$locationProvider',function ($stateProvider,$urlMatcherFactoryProvider,$urlRouterProvider,$locationProvider){
                $urlMatcherFactoryProvider.caseInsensitive(true);
                $stateProvider
                .state("home",{
                    url: "/home",
                    templateUrl : b+"/application/views/home.html", 
                    controller : "homeController"
                })
                .state("signin",{
                    url : "/signin",
                    templateUrl : b+"/application/views/signin.html",
                    controller : "signinController"
                })
                .state("signup",{
                    url : "/signup",
                    templateUrl : b+"/application/views/signup.html",
                    controller : "signupController"
                })
                .state("ticket",{
                    url : "/ticket",
                    templateUrl : b+"/application/views/ticket.html",
                    controller : "ticketController"
                })
                .state("users",{
                    url : "/users/:page",
                    templateUrl : b+"/application/views/user.html",
                    controller : "userController"
                }) 
                .state("logout",{
                    url : "/signin",
                    templateUrl :  b+"/application/views/signin.html",
                    controller : "logoutController"
                })
                .state("admin",{
                    url : "/admin/:page",
                    templateUrl : b+"/application/views/admin.html",
                    controller : "userController"
                }) 
                .state("userprofiles",{
                    url : "/userprofiles/:userid/:page",
                    templateUrl : b+"/application/views/ticketview.html",
                    controller : "userprofileController"
                }) 
                .state("forgetpassword",{
                    url : "/forgetpassword",
                    templateUrl : b+"/application/views/forgetpassword.html",
                    controller : "forgetpasswordController"
                }) 
                .state("resetpassword",{
                    url : "/resetpassword/:id",
                    templateUrl : b+"/application/views/resetpassword.html",
                    controller : "resetController"
                })
                .state("sessionexpired",{
                    url : "/sessionexpired",
                    templateUrl : b+"/application/views/sessionexpired.html",
                    
                })
                
                $urlRouterProvider.otherwise("/home");
                // $locationProvider.hashPrefix('');
                $locationProvider.html5Mode({
                    enabled: true,
                    requireBase: false
                  });
               
           }])
           .controller('MyController', function ($scope,$rootScope,$http) {
            $rootScope.isHome=0;
            $http({
                method: 'GET',
                url: a+'/welcome/session'
              }).then(function successCallback(response) {
                $rootScope.userid=response.data.userid;
                $rootScope.role=response.data.role;
                });
             
           }) 
           .controller('homeController', function ($scope,$http,$rootScope) {
            $rootScope.isHome=1;
       
        })
        .controller('signinController', function ($scope,$http,$location,$rootScope) {
            $rootScope.isHome=0;
            $scope.formData = {}
            $scope.submit = function(){
                var regdata = {
                    url: a+"/welcome/authenticateuser",
                    method: "POST",
                    data: { 
                        email: $scope.formData.email,
                        password: $scope.formData.password
                    },
                    headers: {'Content-Type': 'application/json'},
                }
                $http(regdata).then(function successCallback(response) {
                    $scope.err=response.data.err;
                    $rootScope.userid=response.data.userid;
                    $rootScope.role=response.data.role;
                    if($scope.err){
                        $scope.err=$scope.err.replace(/<\/?[^>]+(>|$)/g, "");
                        $rootScope.userid=0;
                        $rootScope.role=0;
                        $location.path("/signin");
                    }else{
                        $location.path("/home");
                    }
                        
                }, function errorCallback(response) {
                    $scope.err=response.data.err;
                    $rootScope.userid=0;
                    $rootScope.role=0;
                    $location.path("/signin");
                });
            }
        })
        .controller('signupController', function ($scope,$http,$location,$rootScope) {
            $rootScope.isHome=0;
            $rootScope.userid=0;
            $rootScope.role=0;
            $scope.message = "";
            $scope.formData = {}
            $scope.submit = function(){
                var regdata = {
                    url: a+"/welcome/form",
                    method: "POST",
                    data: { 
                        name: $scope.formData.name,
                        email: $scope.formData.email,
                        password: $scope.formData.password,
                        cpassword: $scope.formData.cpassword,
                        city:$scope.formData.city 
                    },
                    headers: {'Content-Type': 'application/json'},
                }
                $http(regdata).then(function successCallback(response) {
                         $scope.err=response.data.err
                        Object.keys($scope.err).forEach(key => {
                            if($scope.err[key]){
                                $scope.err[key] = $scope.err[key].replace(/<\/?[^>]+(>|$)/g, "");
                            }
                          });
                            if($scope.err){
                            $location.path("/signup");
                        }else{
                            $location.path("/signin");
                        }
                }, function errorCallback(response) {
                    $rootScope.err=response.data.err;
                        $location.path("/signup");
                });
            }
        })
        .controller('ticketController', function ($scope,$http,$location,$rootScope,$scope) {
            console.log($rootScope.userid);
            if(!$rootScope.userid||$rootScope.userid==0){
                $location.path("/signin"); 
            }
            $rootScope.isHome=0;
            $scope.formData = {};
            var form_data= new FormData();
            $scope.fileSelected = function (element) {
                 var myFileSelected = element.files[0];
                 $scope.formData.file=myFileSelected;
                 form_data.append('file',myFileSelected);
            };
            $scope.submit = function(){
                var regdata = {
                    url: a+"/welcome/upload",
                    method: "POST",
                    data: form_data,
                    headers: { 'Content-Type':  undefined },
                }
                $http(regdata).then(function successCallback(response) {
                    $scope.fileerr=response.data.err;
                    if($scope.fileerr){
                        $scope.fileerr=$scope.fileerr.replace(/<\/?[^>]+(>|$)/g, "");
                        $location.path("/ticket");
                    }else{
                        var regdata = {
                            url: a+"/welcome/ticketValidation",
                            method: "POST",
                            data: form_data,
                            data: { 
                                subject: $scope.formData.subject,
                                description: $scope.formData.description,
                                department: $scope.formData.department,
                                category: $scope.formData.category,
                                filename : response.data.filename
                            },
                           
                            headers: { 'Content-Type':  'application/json' },
                        }
                        $http(regdata).then(function successCallback(response) {
                            if(response.data.err){
                                $scope.err=response.data.err;
                                $location.path("/ticket");
                            }else{
                                $location.path("/user");
                            }
                        }, function errorCallback(response) {
                              $scope.err=response.data.err;
                                $location.path("/ticket");
                        });
                    }
                });
                
            }
        })
        .controller('userController', function ($scope,$rootScope, $stateParams,$http,$location) {
            $rootScope.isHome=0;
            if(!$rootScope.userid||$rootScope.userid==0){
                $location.path("/signin");
            }else{
               $scope.getUser =function(){
                 $http({
                    method:'GET',
                    url: a+"/welcome/useraunthitencate/"+$stateParams.page,
                    dataType:"json",
                    params:{page:$stateParams.page},
             }).then(function(response){
              
                $scope.tickets=response.data.tickets;
                $scope.links=response.data.links;
                document.getElementById('pagination').innerHTML=$scope.links;
             },function(err){
                    console.log(err);
             });
            }
            $scope.getUser();
        }
           
        })
        .controller('logoutController',function($scope,$rootScope){
            $rootScope.isHome=0;
            $rootScope.userid=0;
            $rootScope.err=0;
            $rootScope.role=0;
        })
        .controller('userprofileController',function($scope,$rootScope,$http,$stateParams){
            $rootScope.isHome=0;
            if($rootScope.userid==0){
                $location.path("/signin");
            }else{
            $scope.getUser =function(){
                $http({
                   method:'GET',
                   url: a+"/welcome/userprofile/"+$stateParams.userid+"/"+$stateParams.page,
                   dataType:"json",
                   params:{userid:$stateParams.userid ,page:$stateParams.page},
            }).then(function(response){
             
               $scope.tickets=response.data.tickets;
               $scope.links=response.data.links;
               document.getElementById('pagination').innerHTML=$scope.links;
            },function(err){
                $location.path("/user");
            });
           }
           $scope.getUser();
        }
        })
        .controller('forgetpasswordController',function($scope,$http,$location,$rootScope) {
            $rootScope.isHome=0;
            $rootScope.userid=0;
            $rootScope.role=0;
            $scope.message = "";
            $scope.formData = {}
            $scope.submit = function(){
                var regdata = {
                    url: a+"/welcome/emailaunthitencate",
                    method: "POST",
                    data: { 
                        email: $scope.formData.email
                    },
                    headers: {'Content-Type': 'application/json'},
                }
                $http(regdata).then(function successCallback(response) {
                    console.log(response);
                        $scope.err=response.data.err
                        console.log($scope.err);
                            if($scope.err){
                                $location.path("/forgetpassword");
                            }else{
                             $location.path("/home");
                            }
                }, function errorCallback(response) {
                    $scope.err=response.data.err;
                    
                        $location.path("/forgetpassword");
                });
            }
        })
        .controller('resetController',function($scope,$http,$stateParams,$location,$rootScope){
            $http({
                method: 'GET',
                url: a+'/welcome/resetpassword/'+$stateParams.id,
                dataType:"json",
                
              }).then(function successCallback(response) {
                $scope.result=response.data[0].userid;
                if($scope.result === undefined){
                    $location.path("/sessionexpired");
                }else{
                    $rootScope.result=$scope.result;
                    $location.path("/resetpassword/"+$stateParams.id);
                }
                });
              
            $rootScope.isHome=0;
            $rootScope.userid=0;
            $rootScope.role=0;
            $scope.message = "";
            $scope.formData = {}
            $scope.submit = function(){
                var regdata = {
                    url: a+"/welcome/password",
                    method: "POST",
                    data: { 
                        password: $scope.formData.password,
                        cpassword: $scope.formData.cpassword,
                        id: $rootScope.result
                    },
                    headers: {'Content-Type': 'application/json'},
                }
                $http(regdata).then(function successCallback(response) {
                        $scope.err=response.data.err
                            if($scope.err){
                                Object.keys($scope.err).forEach(key => {
                                    if($scope.err[key]){
                                        $scope.err[key] = $scope.err[key].replace(/<\/?[^>]+(>|$)/g, "");
                                    }
                                  });
                                $location.path("/resetpassword/"+response.data.id);
                            }else{
                            $location.path("/sign");
                            }
                }, function errorCallback(response) {
                    $scope.err=response.data.err;
                        $location.path("/resetpassword");
                });
            }
        })
        .controller('logoutController', function ($scope,$rootScope,$http) {
            $rootScope.isHome=0;
            $http({
                method: 'GET',
                url: a+'/welcome/logout'
              }).then(function successCallback(response) {
                $rootScope.userid=response.data.userid;
                $rootScope.role=response.data.role;
                });
             
           }) 
        

        
