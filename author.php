<?php 
session_start();
require 'connection.php';
$id = $_GET['id'];

$sql = "SELECT name, profile FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$user){
    die("No user found");
}
$name = $user['name'];
$profile = $user['profile'];

$sql = "
SELECT
    p.id as post_id,
    p.content,
    p.subject,
    p.created_at,
    u.id as user_id,
    u.name as user_name
FROM posts p
INNER JOIN users u ON u.id = p.user_id
WHERE u.id = :id
ORDER BY created_at DESC

";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $id);

$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$isProfileOwner = $id == $_SESSION['userId'];

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">

    <title>Home - RAHHAL Blog Application</title>

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
                <a class="pull-left" href="#">
                    <img class="media-object" width="64px" height="64px" style="margin-right: 10px;"
                        src="imgs/<?php echo $profile;?>" alt="">
                </a>
                <h2>Posts by <?php echo $name; ?>
                    (<?php
                     echo count($posts);
                     echo count($posts) > 1 ? " Posts" : " Post";
                    ?>)

                </h2>
                <?php 
                    if($isProfileOwner){
                        echo "<a href='update_profile.php'>Change Profile Picture</a>";
                    }
                ?>
            </div>
            <div class="col-md-12">
                <?php 
                    foreach($posts as $post){
                        $date = new DateTime($post['created_at']);
                        $formattedDate = $date->format('F j, Y \a\t g:i A');
                        echo '
                            <h2 class="post-title">
                                <a href="post.php?id='. $post['post_id'].'">'.$post['subject'].'</a>
                            </h2>
                <p>'.$post['content'].'</p>
                <a class="btn btn-default" href="post.html">Read More</a>

                <hr>
                        ';
                    }
                ?>
                <ul class="pager">
                    <li class="previous">
                        <a href="#">Prev</a>
                    </li>
                    <li class="next">
                        <a href="#">Next</a>
                    </li>
                </ul>

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