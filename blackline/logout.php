<?php
session_start();
unset($_SESSION['novel1']);
header("Location:login.php");
exit();



?>