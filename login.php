<?php 
require 'components/checkIfLogin.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">

    <title>BitCast | Blog Website</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/simple-blog-template.css" rel="stylesheet">

</head>

<body>

    <?php 
        require_once 'components/nav.php';
    ?>


    <div class="container">

        <div class="row">

            <div class="col-lg-2"></div>

            <div class="col-lg-8 login">

                <h1>Login</h1>

                <form action="actions/login_action.php" method="post" class="login-form">
                    <div class="form-group">
                        <label for="username">Email</label>
                        <input type="email" id="username" name="email" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Log in</button>
                    <p>Don't have an account? <a href="register.php">Sign Up Now</a></p>
                </form>
                <p style="color:red">
                    <?php 
                    if(isset($_GET['err'])){
                        if($_GET['err'] == 0){
                            echo 'Error logging in. Contact adminstartior';
                        } else if($_GET['err'] == 1){
                            echo 'Missing fields';
                        } else if($_GET['err'] == 2){
                            echo 'Wrong Email Address';
                        } else if($_GET['err'] == 3){
                            echo 'Wrong Password';
                        }
                    }
                ?>
                </p>
            </div>

            <div class="col-lg-2"></div>

        </div>

    </div>

    <?php 
        include_once 'components/footer.php';
    ?>

    <script src="js/jquery.js"></script>

    <script src="js/bootstrap.min.js"></script>



</body>

</html>