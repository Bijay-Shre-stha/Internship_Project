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
  }
  header("Location: /todo/index.php");
    if ($addResult === false) {
      echo "Query error: " . mysqli_error($this->conn);
      return null;
    }
    return $addResult;
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
  }
  header("Location: /todo/index.php");
    if ($deleteResult === false) {
      echo "Query error: " . mysqli_error($this->conn);
      return null;
    }
    return $deleteResult;
  }
  //update
  public function update($sno, $title, $description, $tag)
  {
    $sql = "UPDATE `notes` SET `title` = '$title', `description` = '$description', `tag` = '$tag' WHERE `notes`.`S.No` = $sno";
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
    header("Location: /todo/index.php");
    if ($updateResult === false) {
      echo "Query error: " . mysqli_error($this->conn);
      return null;
    }
    return $updateResult;
  }
}
}
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

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>e-NoteBook</title>
  <link rel="icon" href="./favicon.ico" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="index.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/20cb78088c.js" crossorigin="anonymous"></script>

</head>

<?php

?>

<body>
  <!-- Edit modal -->
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#editModal">Edit Modal</button>
  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="/todo/index.php" method='POST'>
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="mb-3">
              <label for="title" class="form-label">Edit Title</label>
              <input type="text" class="form-control" name="titleEdit" id="titleEdit" required />
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Edit Description</label>
              <input type="text" class="form-control" name="descriptionEdit" id="descriptionEdit" required></input>
            </div>
            <div class="mb-3">
              <label for="tag" class="form-label">Edit Tag</label>
              <input type="text" class="form-control" name="tagEdit" id="tagEdit" required />
            </div>
            <button type="submit" class="btn btn-primary m-2">Update Note</button>
          </form>
        </div>
      </div>
    </div>
  </div>


  <div class="container my-3">
    <h1 class="heading">Add Notes</h1>
    <form action="/todo/index.php" method='POST'>
      <div class="mb-3">
        <label for="title" class="form-label">Add Title</label>
        <input type="text" class="form-control" name="title" id="title" required />
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <input type="text" class="form-control" name="description" id="description" required></input>
      </div>
      <div class="mb-3">
        <label for="tag" class="form-label">Tag</label>
        <input type="text" class="form-control" name="tag" id="tag" required />
      </div>
      <button type="submit" class="btn btn-primary m-2">Add Note</button>
    </form>
  </div>

  <!-- //!database query -->
  <div class="container">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">S.No.</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Tag</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sno = 0;
        if ($result !== null) {
          while ($row = mysqli_fetch_assoc($result)) {
            $sno = $sno + 1;
            echo "<tr>
            <th scope='row'>" . $sno . "</th>
            <td>" . $row["title"] . "</td>
            <td>" . $row["description"] . "</td>
            <td>" . $row["tag"] . "</td>
            <td> 
                <button class='edit btn btn-sm btn-success 'data-bs-toggle='modal' data-bs-target='#editModal' id=" . $row['S.No'] . ">Edit</button>
                <button class='delete btn btn-sm btn-danger' id=" . $row['S.No'] . ">Delete</button>
          </tr>";
          }
        } else {
          echo "<tr><td colspan='5'>No notes available</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
  <script src="https://kit.fontawesome.com/20cb78088c.js" crossorigin="anonymous"></script>
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        tr = e.target.parentNode.parentNode;

        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        tag = tr.getElementsByTagName("td")[2].innerText;
        titleEdit.value = title;
        descriptionEdit.value = description;
        tagEdit.value = tag;
        snoEdit.value = e.target.id;
        $('#editModal').modal('toggle');
      })
    })
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        sno = e.target.id;
        if (confirm("Are you sure you want to delete this note?")) {
          window.location = `/todo/index.php?delete=${sno}`;
        }
      })
    })

    const alertElement = document.querySelector('.alert');
    setTimeout(function() {
      alertElement.remove();
    }, 3000);
  </script>
</body>

</html>