<?php
    session_start();
    require 'includes/env.inc.php';
    include 'includes/autoloader.php';

    /** Head Tags */
    include 'includes/head.inc.php';
?>
<body>
    <?php
        include 'includes/navbar.inc.php';
        
        include 'includes/router.inc.php';

        /** User Authentication */
        function userAuth($url){
            if(isset($_SESSION['user_session']) || isset($_SESSION['security_session']) || isset($_SESSION['admin_session'])){
                return $url;
            } else {
                return 'views/index.view.php';
            }
        }

        /** Admin Authentication */
        function adminAuth($url){
            if(isset($_SESSION['admin_session'])){
                return $url;
            } else {
                return 'views/index.view.php';
            }
        }

        /** Admin Authentication */
        function securityAuth($url){
            if(isset($_SESSION['security_session']) || isset($_SESSION['admin_session'])){
                return $url;
            } else {
                return 'views/index.view.php';
            }
        }
        

        /** Index Page */
        route('/', function(){ 
            if(isset($_SESSION['user_session'])){
                echo "<script> window.location = 'home'; </script>";
            } else if(isset($_SESSION['admin_session'])){
                echo "<script> window.location = 'admin'; </script>";
            } else {
                include 'views/index.view.php'; 
            }
        });

        /** 
         * REGULAR USER ROUTES BEGINS HERE
         */

        /** Security Homepage after login */
        route('/home', function(){ 
            $url = securityAuth('views/home.view.php');
            include $url;
        });

        /** User profile page */
        route('/profile', function(){ 
            $url = userAuth('views/profile.view.php');
            include $url;
        });
        
        /** Reset password page */
        route('/reset-password', function(){ 
            $url = 'views/reset-password.view.php';
            include $url;
        });


        /** User profile page */
        route('/user', function(){ 
            $url = userAuth('views/user-home.view.php');
            include $url;
        });

        /** 
         * REGULAR USER ROUTES ENDS HERE
         */



        /** 
         * ADMIN ROUTES BEGINS HERE
         */

        /** Homepage After Login */
        route('/admin', function(){ 
            $url = adminAuth('views/admin-home.view.php');
            include $url;
        });

        /** Manage Users Page */
        route('/admin/users', function(){ 
            $url = adminAuth('views/admin-users.view.php');
            include $url;
        });


        /** Manage A User Page */
        route('/admin/user/(.+)/?', function($id){ 
            $id = $id;
            $url = adminAuth('views/admin-user.view.php');
            include $url;
        });



        /** 
         * ADMIN ROUTES ENDS HERE
         */

        /** Logout */
        route('/logout', function(){
            session_destroy();
            echo "<script> window.location = '/home'; </script>";
        });

        $action = $_SERVER['REQUEST_URI'];
        dispatch($action);
    ?>

    <?php
        include 'includes/footer.inc.php';

        /** Javacripts */
        include 'includes/scripts.inc.php';
    ?>
</body>
</html>