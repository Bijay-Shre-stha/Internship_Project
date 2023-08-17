<?php
if (!isset($_POST["serial_number"])) {
    die;
}
include("./todoController.php");
$serial_number = $_POST["serial_number"];
$todoManager->delete($serial_number);
    // header("Location: /todo/index.php");
?>