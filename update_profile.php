<?php 
require 'components/checkIfNotLogin.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">

    <title>Home - RAHHAL Blog Template</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/simple-blog-template.css" rel="stylesheet">
</head>

<body>
    <?php 
        require_once 'components/nav.php';
    ?>

    <div class="container">

        <div class="row">
            <div class="col-md-12">

                <h2>
                    Change Profile Picture
                </h2>
                <form method="POST" action="actions/update_profile_action.php" enctype="multipart/form-data">
                    <input type="file" name="profile">
                    <input type="submit" value="Change">
                </form>
                <?php
                if(isset($_GET['err'])){
                    if($_GET['err'] == 1){
                        echo "<p style='color: red'>Couldn't update profile picture</p>";
                    } else if($_GET['err'] == 2){
                        echo "<p style='color: red'>Unsupported File Type</p>";
                    }else if($_GET['err'] == 3){
                        echo "<p style='color: red'>File is too large. Maximum file size is 100KB</p>";
                    }else if($_GET['err'] == 4){
                        echo "<p style='color: red'>Not a valid image</p>";
                    }else if($_GET['err'] == 0){
                        echo "<p style='color: red'>Couldn't update information. Contact adminstartor.</p>";
                    }
                }
            ?>
            </div>

        </div>

    </div>

    </div>

    <?php 
        require_once 'components/footer.php';
    ?>

    <script src="js/jquery.js"></script>

    <script src="js/bootstrap.min.js"></script>




</body>

</html>