<?php

class todoManager
{
  public $conn;
  public function __construct($servername, $username, $password, $database)
  {
    $this->conn = mysqli_connect($servername, $username, $password, $database);
    if (!$this->conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
    else{
        echo "Connected successfully";
    }
  }
  public function add($title, $description, $tag)
  {
    $sql = "INSERT INTO `notes` (`title`, `description`, `tag`) VALUES ('$title', '$description', '$tag')";
    $addResult = mysqli_query($this->conn, $sql);
    if ($addResult) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Your note has been added successfully.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    } else {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error!</strong> We are facing some technical issue and your note was not added successfully. We regret the inconvenience caused!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
  }
  public function delete($sno)
  {
    $sql = "DELETE FROM `notes` WHERE `S.No.` = $sno";
    $deleteResult = mysqli_query($this->conn, $sql);

    if ($deleteResult) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Your note has been deleted successfully.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    } else {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error!</strong> We are facing some technical issue and your note was not deleted successfully. We regret the inconvenience caused!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
  }
  public function update($sno, $title, $description, $tag)
  {
    $sql = "UPDATE `notes` SET `title` = '$title' , `description` = '$description' , `tag` = '$tag' WHERE `notes`.`S.No.` = $sno";
    $updateResult = mysqli_query($this->conn, $sql);
    if ($updateResult) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Your note has been updated successfully.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    } else {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error!</strong> We are facing some technical issue and your note was not updated successfully. We regret the inconvenience caused!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    header("Location: /todo/index.php");
  }
  public function getNotes()
  {
    $sql = "SELECT * FROM `notes`";
    $result = mysqli_query($this->conn, $sql);
    if ($result === false) {
      echo "Query error: " . mysqli_error($this->conn);
      return null;
    }

    return $result;
  }
  public function closeConnection()
  {
    mysqli_close($this->conn);
    exit;
  }
}

try {
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "todo";
  // $result = null;
  $manager = new todoManager($servername, $username, $password, $database);
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['snoEdit'])) {
      //update the record
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
