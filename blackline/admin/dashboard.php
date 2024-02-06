<?php


session_start();
if (isset($_SESSION['novel'])) {

    include("init.php");




    $q1 = $connect->prepare("SELECT * From Users");
    $q1->execute();
    $usercount = $q1->rowcount();


    $q2 = $connect->prepare("SELECT * From Categories");
    $q2->execute();
    $catcount = $q2->rowcount();




    $q3 = $connect->prepare("SELECT * From Posts");
    $q3->execute();
    $postcount = $q3->rowcount();



    $q4 = $connect->prepare("SELECT * From Comments");
    $q4->execute();
    $commentcount = $q4->rowcount();



?>

    <div class="static">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-3 ">
                    <div class="box">
                        <h1><i class="fa-solid fa-user"></i></h1>
                        <h2>Users</h2>
                        <h2><?php echo $usercount  ?></h2>
                        <a href="User.php" class="btn btn-primary mb-4">Show</a>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box">
                        <h1><i class="fa-solid fa-shapes"></i></h1>
                        <h2>Categories</h2>
                        <h2><?php echo $catcount; ?></h2>
                        <a href="categories.php" class="btn btn-info mb-4">Show</a>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box">
                        <h1><i class="fa-solid fa-paste"></i></h1>
                        <h2>Posts</h2>
                        <h2><?php echo $postcount; ?></h2>
                        <a href="posts.php" class="btn btn-success mb-4">Show</a>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box">
                        <h1><i class="fa-solid fa-comments"></i></h1>
                        <h2>Comments</h2>
                        <h2> <?php echo $commentcount  ?> </h2>
                        <a href="comments.php" class="btn btn-danger mb-4">Show</a>

                    </div>
                </div>
            </div>
        </div>
    </div>




<?php
    include("includes/temp/footer.php");
} else {

    echo "<h2 style='text-align:center; background:#f00 ; color:#fff'>Login First</h2>";

    header('Refresh:3;url=login.php');
}
?>