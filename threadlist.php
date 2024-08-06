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
        $id = $_GET["cat_id"];
        $sql = "SELECT * FROM `categories` WHERE `category_id`= $id";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $title = $row["category_name"];
            $desc = $row["category_description"];
            echo '<div class="p-5 my-4 bg-body-secondary rounded-3">
                        <div class="container-fluid py-5">
                            <h1 class="display-5 fw-bold">' . $title . '</h1>
                            <p class="col-md-8 fs-4">' . $desc . '</p>
                        </div>
                     </div>';
        }
        ?>

        <!-- Form started -->
         <?php
            $showAlert = false;
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['logedin']) && $_SESSION['logedin'] == true) {
                $thread_title = $_POST["title"];
                $thread_desc = $_POST["desc"];
                
                $thread_title = str_replace("<", "&lt;", $thread_title);
                $thread_title = str_replace(">", "&gt;", $thread_title);
                
                $thread_desc = str_replace("<", "&lt;", $thread_desc);
                $thread_desc = str_replace(">", "&gt;", $thread_desc);
                $user_id = $_SESSION["sno"];
                $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`) VALUES ('$thread_title', '$thread_desc', '$id ', '$user_id')";
                $result = mysqli_query($conn, $sql);
                $showAlert = true;
                if ($showAlert) {
                    echo '
                    <div class="alert alert-success alert-dismissible fade show"      role="alert">
                        <strong>Success!</strong> Your thread has been added. Please wait for community to respond
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
                
            }
         ?>
        <div class="container">
        <h1 class="my-3">Start A Discussion</h1>
        <?php
        if (isset($_SESSION["logedin"]) && $_SESSION["logedin"]==true) {
        echo'
        <form action=" '.$_SERVER["REQUEST_URI"].'" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Problem Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Keep your title as short as possible</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Elaborate your concern</label>
                <textarea class="form-control" id="desc" name="desc"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>';
        }else {
            echo'
            <div class="container mb-5">
                <p class="lead"><span class="fw-bold">You are not loggged in.</span>Please login to be able to start a discussion</p>
            </div>';
        }
        ?>
        </div>
        <!-- Browse Question start -->
        <div class="container"><h1 class="my-3">Brouse Questions</h1></div>
        <?php
        $id = $_GET["cat_id"];
        $sql = "SELECT * FROM `threads` WHERE `thread_cat_id`= $id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $th_id = $row["thread_id"];
            $title = $row["thread_title"];
            $desc = $row["thread_desc"];
            $timestamp = $row["timestamp"];
            $thread_user_id	= $row["thread_user_id"];
            $sql2 = "SELECT `username` FROM `users` WHERE `sno` = '$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $askedby = $row2["username"];
            echo '<div class="container">
                        <div class="d-flex align-items-center my-4">
                            <div class="flex-shrink-0">
                                <img width="35" src="./images/user.png" alt="user">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5><a class="text-dark" href="./thread.php?th_id=' . $th_id . '&askedby='.$askedby.'">' . $title . '</a></h5>
                                <p class="my-0">' . $desc . '</p>
                                 <p class="fw-bold my-0">Asked by: '.$askedby.' at '. $timestamp .'</p>
                            </div>
                        </div>
                </div>';
        }
        if ($noResult) {
            echo '<div class="container">
                    <div class="p-5 my-4 bg-body-secondary rounded-3">
                        <div class="container-fluid py-5">
                            <h1 class="display-6 fw-bold">No Threads Found</h1>
                            <p class="col-md-8 fs-4">Be the first Person to ask a question</p>
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