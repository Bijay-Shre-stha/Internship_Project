<?php
class todoManager
{
    private $conn;
    function __construct($servername, $username, $password, $database)
    {
    $this->conn = mysqli_connect($servername, $username, $password, $database);
    if (!$this->conn) {
        die("Connection failed: " . mysqli_connect_error());
        }
    }
  //getNotes
    public function getNotes()
    {
    $sql = "SELECT * FROM `notes`";
    $getResult = mysqli_query($this->conn, $sql);
    if ($getResult === false) {
        echo "Query error: " . mysqli_error($this->conn);
        return null;
    }
    return $getResult;
    }
  //add
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
        header("Location: /todo/index.php");
        if ($addResult === false) {
        echo "Query error: " . mysqli_error($this->conn);
        return null;
        }
        return $addResult;
    }
}
  //delete
    public function delete($sno)
    {
    $sql = "DELETE FROM `notes` WHERE `notes`.`S.No` = $sno";
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
        header("Location: /todo/index.php");
        if ($deleteResult === false) {
        echo "Query error: " . mysqli_error($this->conn);
        return null;
        }
        return $deleteResult;
    }
}
  //update
    public function update($sno, $title, $description, $tag)
    {
        $sql = "UPDATE `notes` SET `title` = '$title', `description` = '$description', `tag` = '$tag', `last_update` = NOW() WHERE `notes`.`S.No` = $sno";
    $updateResult = mysqli_query($this->conn, $sql);
    if ($updateResult) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your note has been updated successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }   else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> We are facing some technical issue and your note was not updated successfully. We regret the inconvenience caused!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        header("Location: /todo/index.php");
        if ($updateResult === false) {
        echo "Query error: " . mysqli_error($this->conn);
        return null;
        }
        return $updateResult;
        }
    }
}
?>