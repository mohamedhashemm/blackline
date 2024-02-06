<?php
session_start();
unset($_SESSION['novel']);
header("Location:login.php");
exit();



?>