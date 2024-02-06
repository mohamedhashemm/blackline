<?php

session_start();
if (isset($_SESSION['novel'])) {
    header('Location:dashboard.php');
}



include("includes/temp/header.php");

include("includes/db/db.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['submit-login'])) {

        $user = $_POST['email'];
        $password = $_POST['pass'];


        $statment = $connect->prepare("SELECT * FROM users WHERE `email`=? and `password`=? limit 1");
        $statment->execute(array($user, $password));
        $userCount = $statment->rowCount();
        if ($userCount > 0) {
            $result = $statment->fetch();

            if ($result['role'] == "admin") {
                if ($result['status'] == 1) {
                    $_SESSION['novel'] = $result['email'];

                    header("Location:dashboard.php");
                } else {

                    echo "<h4 class='alert alert-info text-center'>You Are Not Active</h4>";
                }
            } else {

                echo "<h4 class='alert alert-warning text-center'>You Are User Not Admin</h4>";
            }
        } else {

            echo "<h4 class='alert alert-danger text-center'>Creat A New Account First</h4>";
        }
    }
}

?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center"> Admin login</h2>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])  ?>">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" name="email">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" name="pass">
                </div>

                <button name="submit-login" type="submit" class="btn btn-primary btn-block">Submit</button>
            </form>
        </div>
    </div>
</div>







<?php
include('includes/temp/footer.php');
?>