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

  if($_SERVER['REQUEST_METHOD'] == "POST"){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $tag = $_POST['tag'];
    $sql = "INSERT INTO `notes` (`title`, `description`, `tag`) VALUES ('$title', '$description', '$tag')";
    $result = mysqli_query($conn, $sql);
    if($result){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Your note has been added successfully.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    } else {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error!</strong> We are facing some technical issue and your note was not added successfully. We regret the inconvinience caused!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
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
  <div class="container my-3">
    <h1>Add a Note</h1>
    <form action="/todo/index.php" method='post'>
    <div class="mb-3">
        <label for="title" class="form-label">Add Title</label>
        <input type="text" class="form-control" name="title" id="title" required />
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea type="text" class="form-control" name="description" id="description" required></textarea>
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
            
            if ($num > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                    <th scope='row'>" . $row['S.No'] . "</th>
                    <td>" . $row["title"] . "</td>
                    <td>" . $row["description"] . "</td>
                    <td>" . $row["tag"] . "</td>
                    <td> 
                    <button class='icon_button fa-solid fa-user-pen mx-2'>Edit</button> 
                    <button class='icon_button fa-solid fa-trash mx-2'>Delete</button> </td>
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

</body>

</html>
