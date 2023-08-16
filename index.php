<?php
//todo   INSERT INTO `notes` (`S.No`, `title`, `description`, `tag`, `tstamp`) VALUES ('1', 'check', 'is this really working??', 'check', current_timestamp());
 // Connecting to db
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "todo";
  try {
    $conn = mysqli_connect($servername, $username, $password, $database);
  } catch (Exception $e) {
    echo "Error: " . $e->getMessage();
  }

  //  Create or Update a note
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['snoEdit'])) {
        // Update the record
        $sno = $_POST["snoEdit"];
        $title = $_POST["titleEdit"];
        $description = $_POST["descriptionEdit"];
        $tag = $_POST["tagEdit"];

        // Sql query to be executed
        $sql = "UPDATE `notes` SET `title` = '$title' , `description` = '$description' , `tag` = '$tag' WHERE `notes`.`S.No` = $sno";
        $updateResult = mysqli_query($conn, $sql);

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
      exit;
    } else {
        $title = $_POST["title"];
        $description = $_POST["description"];
        $tag = $_POST["tag"];

        // Sql query to be executed
        $sql = "INSERT INTO `notes` (`title`, `description`, `tag`) VALUES ('$title', '$description', '$tag')";
        $addResult = mysqli_query($conn, $sql);

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
      exit;
    }
}


if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $sql = "DELETE FROM `notes` WHERE `S.No` = $sno";
    $deleteResult = mysqli_query($conn, $sql);

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
    exit;
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>e-NoteBook</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="index.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>


<body>
  <!-- //!Edit modal -->
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
              <input  type="text" class="form-control" name="descriptionEdit" id="descriptionEdit" required></input>
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
    <h1>Add Notes</h1>
    <form action="/todo/index.php?" method='POST'>
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
            $sql = "SELECT * FROM `notes`";
            $result = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($result);
            $sno = 0;
            if ($num > 0) {
                while ($row = $result->fetch_assoc()) {
                  $sno =$sno +1;
                    echo "<tr>
                    <th scope='row'>" . $sno . "</th>
                    <td>" . $row["title"] . "</td>
                    <td>" . $row["description"] . "</td>
                    <td>" . $row["tag"] . "</td>
                    <td> 
                    <button class='edit btn btn-sm btn-primary'data-bs-toggle='modal' data-bs-target='#editModal' id=".$row['S.No'].">Edit</button>
                    <button class='delete btn btn-sm btn-danger' id=".$row['S.No'].">Delete</button>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No notes available</td></tr>";
            }
        ?>
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log('edit');
            tr = e.target.parentNode.parentNode;
            title = tr.getElementsByTagName("td")[0].innerText;
            description = tr.getElementsByTagName("td")[1].innerText;
            tag = tr.getElementsByTagName("td")[2].innerText;
            console.log(title, description, tag);
            titleEdit.value = title;
            descriptionEdit.value = description;
            tagEdit.value = tag;
            snoEdit.value = e.target.id;
            console.log(e.target.id);
            $('#editModal').modal('toggle');
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log('delete',);
            sno = e.target.id;
            if (confirm("Are you sure you want to delete this note!")) {
                console.log("yes");
                window.location = `/todo/index.php?delete=${sno}`;
            }
        });
    });
});
  </script>
</body>

</html>