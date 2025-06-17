<?php 
require 'components/checkIfLogin.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign up Page</title>
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

            <div class="col-lg-8 signup">

                <h1>Sign up</h1>
                <form action="actions/register_action.php" method="post" class="signup-form">
                    <div class="form-group">
                        <label for="username">Email</label>
                        <input type="email" id="email" name="email" class="form-control"
                        value="<?php echo isset($_SESSION['register_email']) ? htmlspecialchars($_SESSION['register_email']) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username"
                        value="<?php echo isset($_SESSION['register_name']) ? htmlspecialchars($_SESSION['register_name']) : ''; ?>" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password Confirmation</label>
                        <input type="password" id="confirmation" name="password_confirmation" class="form-control"
                            required>
                    </div>

                    <button type="submit" class="btn btn-primary">Sign up</button>
                </form>
                <p style="color:red">
                    <?php 
                    if(isset($_GET['err'])){
                        if($_GET['err'] == 0){
                            echo 'Error registering. Contact adminstartior';
                        } else if($_GET['err'] == 1){
                            echo 'Missing fields';
                        } else if($_GET['err'] == 2){
                            echo 'Invalid Email Address';
                        } else if($_GET['err'] == 3){
                            echo 'Password should be 8 characters minimum';
                        } else if($_GET['err'] == 4){
                            echo 'Email Address already in use';
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
    <?php
     $_SESSION['register_email'] = "";
     $_SESSION['register_name'] = "";
    ?>
</body>

</html>