<?php
try {
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "todo";
  global $result;
  $manager = new todoManager($servername, $username, $password, $database);
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['snoEdit'])) {
      $sno = $_POST["snoEdit"];
      $title = $_POST["titleEdit"];
      $description = $_POST["descriptionEdit"];
      $tag = $_POST["tagEdit"];
      $result = $manager->update($sno, $title, $description, $tag);
    } else {
      $title = $_POST["title"];
      $description = $_POST["description"];
      $tag = $_POST["tag"];
      $result = $manager->add($title, $description, $tag);
    }
  }
  if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $result = $manager->delete($sno);
  }

  $result = $manager->getNotes();
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}
?>