<?php 
session_start();
require 'connection.php';
if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']){
    $sql = "
SELECT
        p.id as post_id,
        p.content,
        p.subject,
        p.created_at,
        u.id as user_id,
        u.name as user_name,
        l.id as isLiked,
        count(l2.id) as numLikes
FROM posts p
INNER JOIN users u ON u.id = p.user_id
LEFT JOIN likes l ON l.post_id = p.id AND l.user_id = ".$_SESSION['userId']." 
LEFT JOIN likes l2 ON l2.post_id = p.id
GROUP BY p.id, p.content, p.subject, p.created_at, u.id, u.name, l.id
ORDER BY created_at DESC
    ";
} else {
    $sql = "
    SELECT
            p.id as post_id,
            p.content,
            p.subject,
            p.created_at,
            u.id as user_id,
            u.name as user_name,
            count(l2.id) as numLikes
    FROM posts p
    INNER JOIN users u ON u.id = p.user_id
    LEFT JOIN likes l2 ON l2.post_id = p.id
    GROUP BY p.id, p.content, p.subject, p.created_at, u.id, u.name
    ORDER BY created_at DESC
    ";
}

$stmt = $pdo->query($sql);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                <?php 
                    foreach($posts as $post){
                        $date = new DateTime($post['created_at']);
                        $formattedDate = $date->format('F j, Y \a\t g:i A');
                        echo '
                            <div>
                                <h2 class="post-title">
                                    <a href="post.php?id='. $post['post_id'].'">'.$post['subject'].'</a>
                                </h2>
                                <a href="author.php?id='. $post['user_id'].'" class="lead">
                                    by '.$post['user_name'].'
                                </a>
                                <p><span class="glyphicon glyphicon-time"></span> Posted on '.$formattedDate.'</p>
                                <p>'.$post['content'].'</p>
                                <a class="btn btn-default" href="post.php?id='. $post['post_id'].'">Read More</a>';
                                if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true){
                                    echo "<form method='POST' action='actions/like_action.php' style='display: inline; margin-left: 5px;'>";
                                    echo "<input type='hidden' name='post_id' value='". $post['post_id']."'>";
                                    echo '<button id="btn'.$post['post_id'].'" class="btn btn-default" type="button" onclick="like('.$post['post_id'].')" href="post.php">'. ($post['isLiked'] == null ? "Like" : "Unlike") .'</button></form>';
                                }
                                echo '<p><span id="num'.$post['post_id'].'">'. $post['numLikes'] . '</span> people likes this</p>';
                                echo '<hr>
                            </div>
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
        include_once 'components/footer.php';
    ?>

    <script src="js/jquery.js"></script>

    <script src="js/bootstrap.min.js"></script>

    <script>
        function like(id){
            const myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            const urlencoded = new URLSearchParams();
            urlencoded.append("post_id", id);

            const requestOptions = {
                method: "POST",
                headers: myHeaders,
                body: urlencoded,
                redirect: "follow"
            };

            fetch('actions/like_action.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({ post_id: 123 })
})
.then(response => response.json())
.then(data => {
    console.log(data);
});

        }

        function likeSuccess(result, id){
            const num = document.getElementById("num" + id);
            const btn = document.getElementById("btn" + id);

            if(result.status == "error"){
                alert(result.result);
                return;
            }

            if(result.result == "Unlike"){
                num.innerHTML = num.innerHTML - 1;
                btn.innerHTML = "Like";
            } else {
                num.innerHTML = parseInt(num.innerHTML) + 1;
                btn.innerHTML = "Unlike";

            }
        }
    </script>
</body>

</html>