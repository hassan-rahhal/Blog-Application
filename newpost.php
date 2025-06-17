<?php 
    require 'components/checkIfNotLogin.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">

    <title>RAHHAL Blog Application</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/simple-blog-template.css" rel="stylesheet">

</head>

<body>

    <!-- Navigation -->
    <?php 
        require_once 'components/nav.php';
    ?>



    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Newpost content  -->
            <div class="col-lg-12 newpost">

                <!-- Title -->
                <h1>New post</h1>

                <!-- Newpost form -->
                <form action="actions/post_action.php" method="post" class="newpost-form">
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea rows="5" id="content" name="content" class="form-control" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Post</button>
                </form>
                <!-- /form -->
                <p style="color:red">
                    <?php 
                    if(isset($_GET['err'])){
                        if($_GET['err'] == 0){
                            echo 'Error posting. Contact adminstartior';
                        } else if($_GET['err'] == 1){
                            echo 'Missing fields';
                        }
                    }
                ?>
                </p>
            </div>

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <?php 
        include_once 'components/footer.php';
    ?>


    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>



</body>

</html>