<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDiscuss</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php
    include "./partials/dbConnection.php";
    include "./partials/header.php";
    ?>
    <div class="container min-vh-100">
        <!-- jumbotron start -->
        <?php
        $id = $_GET["th_id"];
        $Posted_by = $_GET["askedby"];
        $sql = "SELECT * FROM `threads` WHERE `thread_id`= $id";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $title = $row["thread_title"];
            $desc = $row["thread_desc"];
            echo '<div class="p-5 my-4 bg-body-secondary rounded-3">
                        <div class="container-fluid py-5">
                            <h1 class="display-6 fw-bold">'.$title.'</h1>
                            <p class="col-md-8">'.$desc.'</p>
                            <p>Posted by: <span class="fw-bold">'.$Posted_by.'</span></p>
                        </div>
                     </div>';
        }
        ?>
          <!-- Form started -->
          <?php
            $showAlert = false;
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['logedin']) && $_SESSION['logedin'] == true) {
                $comment_content = $_POST["Ccontent"];
                $comment_content = str_replace("<", "&lt;", $comment_content);
                $comment_content = str_replace(">", "&gt;", $comment_content);
                $comment_by = $_SESSION["sno"];
                $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`) VALUES ('$comment_content','$id ', '$comment_by')";
                $result = mysqli_query($conn, $sql);
                $showAlert = true;
                if ($showAlert) {
                    echo '
                    <div class="alert alert-success alert-dismissible fade show"      role="alert">
                        <strong>Success!</strong> Your comment has been added.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
                
            }
         ?>
        <div class="container">
        <h1 class="my-3">Post a comment</h1>
        <?php
        if (isset($_SESSION["logedin"]) && $_SESSION["logedin"]==true) {
            echo
            '<form action="'. $_SERVER["REQUEST_URI"].' " method="POST">
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Type your comment</label>
                    <textarea class="form-control" id="Ccontent" name="Ccontent"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Post comment</button>
            </form>';
        }else {
            echo'
            <div class="container mb-5">
                <p class="lead"><span class="fw-bold">You are not loggged in.</span>Please login to be able to start comment</p>
            </div>';
        }
        ?>
        </div>
        <!-- Discussion start  -->
        <div class="container"><h1 class="my-3">Discussion</h1></div>
        <?php
        $id = $_GET["th_id"];
        $sql = "SELECT * FROM `comments` WHERE `thread_id`= $id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $comment_content = $row["comment_content"];
            $comment_by = $row["comment_by"];
            $comment_time = $row["comment_time"];
            $sql2 = "SELECT `username` FROM `users` WHERE `sno` = '$comment_by'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            echo'<div class="container">
                        <div class="d-flex align-items-center my-4">
                            <div class="flex-shrink-0">
                                <img width="35" src="./images/user.png" alt="user">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="fw-bold my-0">'.$row2["username"].' at '.$comment_time .'</p>
                                '.$comment_content.'
                            </div>
                        </div>
                </div>';
        }
        if ($noResult) {
            echo'<div class="container">
                    <div class="p-5 my-4 bg-body-secondary rounded-3">
                        <div class="container-fluid py-5">
                            <h1 class="display-6 fw-bold">No Comment Found</h1>
                            <p class="col-md-8 fs-4">Be the first Person to make a comment</p>
                        </div>
                     </div>
                 </div>';
        }
        ?>
    </div>
    <?php
        include "../Forum/partials/footer.php"
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>