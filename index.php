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
    include "partials/dbConnection.php";
    include "partials/header.php"
    ?>
    <!-- carousel start -->
    <div id="carouselExampleAutoplaying" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img height="500" src="./images/carousel1.avif" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img height="500" src="./images/carousel2.avif" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img height="500" src="./images/carousel3.avif" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- Categories card start -->
    <div class="container min-vh-100">
        <h1 class="text-center fs-2 my-4">iDiscuss-Browse Categories</h1>
        <div class="row">
            <?php
                include "partials/dbConnection.php";
                $sql = "SELECT * FROM `categories`";
                $results = mysqli_query($conn,$sql);
                while ($row = mysqli_fetch_assoc($results)) {
                    $id = $row["category_id"];
                    $Cname = $row["category_name"];
                    $Cdesc = $row["category_description"];
                    echo'
                        <div class="col-md-4 d-flex justify-content-center                  align-items-center ">
                                <div class="card my-4" style="width: 18rem;">
                                    <img src="./images/card.avif" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">'.$Cname.'</h5>
                                        <p class="card-text">'.substr($Cdesc,0,90).'...</p>
                                        <a href="./threadlist.php?cat_id='.$id.'" class="btn btn-primary">View Threads</a>
                                    </div>
                                </div>
                            </div>';
                }
            ?>
        </div>
    </div>
    <?php
    include "partials/footer.php"
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>