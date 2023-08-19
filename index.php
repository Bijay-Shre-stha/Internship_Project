<?php include './todoController.php'?>
<?php include './database.php';?>

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
    <h1 class="heading fw-bold">Add Notes</h1>
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
          <th scope="col">Last Update</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sno = 0;
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $sno = $sno + 1;
            echo "<tr>
          <th scope='row'>" . $sno . "</th>
          <td>" . $row["title"] . "</td>
          <td>" . $row["description"] . "</td>
          <td>" . $row["tag"] . "</td>
          <td class='text-danger'><b>". $row["last_update"]. "</b></td>
          <td> 
              <button class='edit btn btn-sm btn-success 'data-bs-toggle='modal' data-bs-target='#editModal' id=" . $row['S.No'] . ">Edit</button>
              <button class='delete btn btn-sm btn-danger' id=" . $row['S.No'] . ">Delete</button>
        </tr>";
          }
        } else {
          echo "<trz><td colspan='5'>No notes available</td></trz>";
        }
        ?>
      </tbody>
    </table>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
  <script src="https://kit.fontawesome.com/20cb78088c.js" crossorigin="anonymous"></script>
  <script src="index.js">
  </script>
</body>

</html>