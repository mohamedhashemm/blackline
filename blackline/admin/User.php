<?php

session_start();
if (isset($_SESSION['novel'])) {


include("init.php");
$statment = $connect->prepare("SELECT * FROM users");
$statment->execute();
$usercount = $statment->rowCount();
$result = $statment->fetchAll();
$page = "All";
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = "All";
}
if (($page == "All")) {


?>


    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 m-auto text-center">
                <h2 class="text-center">Number Of Row:<span class="badge badge-info"> <?php echo $usercount;  ?></span>
                    <a href="?page=create-user" class="btn btn-success">Creat New Row</a>
                </h2>
                <table class="table table-dark ">
                    <thead>
                        <tr>
                            <th>User_id</th>
                            <th>Usernme</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Status</th>
                            <th>Role</th>
                            <th>Created_at</th>
                            <th>Operation</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if ($usercount > 0) {

                            foreach ($result as $x) {

                        ?>
                                <tr>

                                    <td> <?php echo $x['user_id'] ?></td>
                                    <td> <?php echo $x['usernme'] ?></td>
                                    <td> <?php echo $x['email'] ?></td>
                                    <td> <?php echo $x['password'] ?></td>
                                    <td> <?php echo $x['status'] ?></td>
                                    <td> <?php echo $x['role'] ?></td>
                                    <td> <?php echo $x['created_at'] ?></td>
                                    <td> <?php echo $x['updated_at'] ?></td>
                                    <td>
                                        <a href="?page=show&user_id=<?php echo $x['user_id'] ?>" class="btn btn-success"><i class="fa-regular fa-eye"></i></a>
                                    </td>
                                    <td>
                                        <a href="?page=deleteuser&user_id=<?php echo $x['user_id'] ?>" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></a>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>



            </div>
        </div>
    </div>


    <?php
} elseif ($page == "show") {


    $user_id = "";
    if (isset($_GET['user_id'])) {

        $user_id = $_GET['user_id'];
    } else {
        $user_id = "";
    }

    $statment = $connect->prepare('SELECT * FROM users where user_id=?');

    $statment->execute(array($user_id));
    $result = $statment->fetchAll();

    foreach ($result as $x) {
    ?>
        <div class="container  m-4">
            <div class="row">
                <div class="col-md-10 m-auto">
                    <h2 class="text-center m-auto">Show & Edite</h2>
                    <form method="POST" action="?page=updateuser&novel=<?php echo $x['user_id'] ?>">
                        <div class="form-group">
                            <label>ID</label>
                            <input type="number" value="<?php echo $x['user_id']; ?>" class="form-control" name="id">

                        </div>

                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" value="<?php echo $x['usernme'] ?>" class="form-control" name="username">

                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" value="<?php echo $x['email'] ?>" class="form-control" name="email">

                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Password</label>
                            <input type="password" value="<?php echo $x['password']  ?>" class="form-control" name="pass">

                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <?php
                                if ($x['status'] == 0) {


                                ?>
                                    <option value="0" selected>0</option>
                                    <option value="1">1</option>
                                <?php
                                } else {
                                ?>
                                    <option value="0">0</option>
                                    <option value="1" selected>1</option>
                                <?php
                                }
                                ?>
                            </select>

                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select name="role" class="form-control">
                                <?php
                                if ($x['role'] == 'user') {
                                ?>

                                    <option value="user" selected>user</option>
                                    <option value="admin">admin</option>

                                <?php
                                } else {
                                ?>
                                    <option value="admin" selected>admin</option>
                                    <option value="user">user</option>

                                <?php
                                }

                                ?>


                            </select>

                        </div>



                        <button type="submit" name="submit-user" class="btn btn-primary btn-block">Submit</button>
                    </form>
                </div>
            </div>
        </div>


    <?php

    }
} else if ($page == 'updateuser') {

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['submit-user'])) {
            $novel = "";
            if (isset($_GET['novel'])) {
                $novel = $_GET['novel'];
            } else {
                $novel = "";
            }
            $id = $_POST['id'];


            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['pass'];

            $status = $_POST['status'];
            $row = $_POST['role'];
            $statment = $connect->prepare('UPDATE users SET
            `user_id`=?,
            `usernme`=?,
            `email`=?,
            `password`=?,
            `status`=?,
            `role`=?
            where user_id=?
            ');

            $statment->execute(array($id, $username, $email, $password, $status, $row, $novel));


            echo "<h2 class='alert alert-info text-center'>update successfully</h2>";


            header("refresh:3;url=User.php?page=All");
        }
    }
} elseif ($page == 'create-user') {
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-10 m-auto">
                <h2 class="text-center">Add New User</h2>
                <form method="post" action="?page=save-new-user">

                    <div class="form-group">
                        <label for="exampleInputEmail1">Id</label>
                        <input type="number" class="form-control" name="id">

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Username</label>
                        <input type="text" class="form-control" name="username">

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email </label>
                        <input type="email" class="form-control" name="email">

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">password</label>
                        <input type="password" class="form-control" name="pass">

                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="0">Active</option>
                            <option value="1">Block</option>

                        </select>

                        <div class="form-group">
                            <label>role</label>
                            <select name="role" class="form-control">
                                <option value="admin">admin</option>
                                <option value="user">user</option>

                            </select>

                        </div>


                        <button type="submit" class="btn btn-primary btn-block" name="submit-save-user">Submit</button>
                </form>
            </div>
        </div>
    </div>

<?php

} else if ($page == "save-new-user") {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $old_id = $_POST['id'];
            $statment = $connect->prepare("SELECT * FROM users WHERE user_id=?");
            $statment->execute(array($old_id));
            $allcount = $statment->rowCount();
            if ($allcount > 0) {

                echo "<h2 class='alert alert-danger text-center'>Id Aready Exists</h2>";

                header("refresh:3;url=?page=create-user");
                exit();
            }
        }
        if (isset($_POST['submit-save-user'])) {
            $id = $_POST['id'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['pass'];
            $status = $_POST['status'];
            $role = $_POST['role'];
            $statment = $connect->prepare("INSERT INTO users(user_id,usernme,email,`password`,`status`,`role`)
            VALUES(?,?,?,?,?,?) ");
            $statment->execute(array($id, $username, $email, $password, $status, $role));

            echo "<h2 class='alert alert-success text-center'> Creat successfully</h2>";

            header("refresh:3;url=User.php?page=All");
        }
    }
}else if($page=="deleteuser"){
    $user_id="";
    if(isset($_GET['user_id'])){

        $user_id=$_GET['user_id'];


    }else{
        $user_id="";

    }

    $statment=$connect->prepare("DELETE FROM users WHERE user_id=? ");
    $statment->execute(array($user_id));

    echo"<h2 class='alert alert-danger text-center'>Delete successfully</h2>";
    header("refresh:3;url=user.php");

}

 

?>

<?php
include("includes/temp/footer.php");
} else {

    echo "<h2 style='text-align:center; background:#f00 ; color:#fff'>Login First</h2>";

    header('Refresh:3;url=login.php');
}

?>