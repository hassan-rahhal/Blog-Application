<?php 
require 'connection.php';

$id = $_GET['id'];

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
WHERE p.id = :id
";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$post){
    die("Post doesn't exist");
}
$date = new DateTime($post['created_at']);
$formattedDate = $date->format('F j, Y \a\t g:i A');

$sql = "
SELECT 
    c.id as comment_id,
    c.content,
    c.created_at,
    u.id as user_id,
    u.name,
    u.profile
FROM comments c
INNER JOIN users u ON u.id = c.user_id
WHERE post_id = :id AND comment_id IS NULL

";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

            <div class="col-lg-12">


                <h1 class="post-title"><?php echo $post['subject'];?></h1>

                <a href="author.php?id=<?php echo $post['post_id'];?>" class="lead">
                    by <?php echo $post['user_name'];?>
                </a>

                <hr>

                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $formattedDate; ?></p>

                <hr>

                <p><?php echo $post['content'];?></p>

                <hr>


                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" method="POST" action="actions/comment_action.php">
                        <input type="hidden" value="<?php echo $id; ?>" name="post_id">
                        <div class="form-group">
                            <textarea class="form-control" rows="3" name="content"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                 <?php
                    if(!$comments){
                        echo "<h4>No comments yet</h4>";
                    }
                    foreach($comments as $comment){
                        $sql = "
                        SELECT 
                            c.id as comment_id,
                            c.content,
                            c.created_at,
                            u.id as user_id,
                            u.name,
                            u.profile
                        FROM comments c
                        INNER JOIN users u ON u.id = c.user_id
                        WHERE comment_id = :comment_id

                        ";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(":comment_id", $comment['comment_id']);
                        $stmt->execute();
                        $replies = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        $date = new DateTime($comment['created_at']);
                        $formattedDate = $date->format('F j, Y \a\t g:i A');
                        echo '
                         <div class="media">
                            <a class="pull-left" href="#">
                                <img width="64px" height="64px" class="media-object" src="imgs/'.$comment['profile'].'" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="author.php?id='.$comment['user_id'].'">'.$comment['name'].'
                                    </a><small>'.$formattedDate.'</small>
                                </h4>
                                '.$comment['content'].'
                                 <!-- Nested Comment -->
                                    <div class="media">
                                        <div class="well">
                                        <h4>Leave a Reply:</h4>
                                        <form role="form" method="POST" action="actions/comment_action.php">
                                            <input type="hidden" value="'. $id. '" name="post_id">
                                            <input type="hidden" value="'. $comment['comment_id']. '" name="comment_id">

                                            <div class="form-group">
                                                <textarea class="form-control" rows="3" name="content"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                    </div>
                                    </div>
                                <!-- End Nested Comment -->
                                ';
                                foreach($replies as $reply){
                                    $date = new DateTime($reply['created_at']);
                                    $formattedDate2 = $date->format('F j, Y \a\t g:i A');
                                    echo '
                                     <!-- Nested Comment -->
                                        <div class="media">
                                            <a class="pull-left" href="#">
                                            <img width="64px" height="64px" class="media-object" src="imgs/'.$reply['profile'].'" alt="">
                                            </a>
                                            <div class="media-body">
                                                <h4 class="media-heading"><a href="author.php?id='.$reply['user_id'].'">'.$reply['name'].'
                                                    </a><small>'.$formattedDate2.'</small>
                                                </h4>
                                                  '.$reply['content'].'
                                            </div>
                                        </div>
                                        <!-- End Nested Comment -->
                                    ';
                                }

                            echo '</div>
                        </div>
                        ';
                    }
                 ?>
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