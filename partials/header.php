<?php
session_start();
echo '<nav class="sticky-top navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">iDiscuss</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Categories
          </a>
          <ul class="dropdown-menu">';
          $sql = "SELECT `category_name`, `category_id` FROM `categories`";
          $result = mysqli_query($conn,$sql);
          while ($row = mysqli_fetch_assoc($result)) {
            $category_name = $row['category_name'];
            $category_id = $row['category_id'];
           echo '<li><a class="dropdown-item" href="threadlist.php?cat_id='.$category_id.'">'.$category_name.'</a></li>';
          };
          echo '</ul>
      </ul>
      <form class="d-flex" role="search" method="get" action="./search.php">
        <input class="form-control me-2" name="query" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>';
      if (isset($_SESSION['logedin']) && $_SESSION['logedin'] == true) {
        echo '         
            <div class="dropdown">
              <button class="btn btn-outline-success dropdown-toggle mx-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Welcome '.$_SESSION['username'].'
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/forum/partials/logout.php">Logout</a></li>
              </ul>
            </div>';
      }else {
        echo'
        <button class="btn btn-outline-success mx-2" type="button"     data-bs-toggle="modal" data-bs-target="#loginModal">
        Login
        </button>
        <button class="btn btn-outline-success mx-2" type="button" data-bs-toggle="modal" data-bs-target="#signupModal">
          Signup
        </button>';
      }
      echo'
    </div>
  </div>
</nav>';
include "./partials/signup.php";
include "./partials/login.php";
if (isset($_GET["signupsucess"])&& $_GET["signupsucess"] == "true") {
  echo'<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <strong>Success!</strong> Now you can login.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if (isset($_GET["signupsucess"])&& $_GET["signupsucess"] == "false"){
  $err = $_GET["error"];
   echo'<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
   '.$err.'
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if (isset($_GET["logedin"])&& $_GET["logedin"] == "false"){
  $Lerror = $_GET["error"];
   echo'<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
   '.$Lerror.'
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
