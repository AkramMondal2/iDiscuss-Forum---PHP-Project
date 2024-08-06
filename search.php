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
        <!-- Search start -->
        <div class="container "><h1 class="my-4">Search result for <?php echo $_GET["query"]; ?></h1></div>
        <?php
        $query = $_GET["query"];
        $sql = "SELECT * FROM `threads` WHERE MATCH (`thread_title`,`thread_desc`) AGAINST ('$query')";
        $result = mysqli_query($conn, $sql);
        print_r($result);
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
                            <h1 class="display-6 fw-bold">No Results Found</h1>
                            <p class="col-md-8 fs-4">Suggestions:
                                <li>Try diffrent keywords.</li>
                                <li>Try more general keywords.</li>
                            </p>
                        </div>
                     </div>
                 </div>';
        }
        ?>
    </div>
    <?php
    include "./footer.php"
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>