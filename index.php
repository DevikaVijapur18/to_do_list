<?php   
// Connect to the Database
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

$insert = false;
$update = false;
$delete = false;

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn){
    die("Sorry we failed to connect: ". mysqli_connect_error());
}

// DELETE Record
if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
  $result = mysqli_query($conn, $sql);
}

// INSERT & UPDATE Record
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset( $_POST['snoEdit'])){
        // Update Logic
        $sno = $_POST["snoEdit"];
        $title = mysqli_real_escape_string($conn, $_POST["titleEdit"]);
        $description = mysqli_real_escape_string($conn, $_POST["descriptionEdit"]);

        $sql = "UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`sno` = $sno";
        $result = mysqli_query($conn, $sql);
        if($result){
            $update = true;
        }
    }
    else{
        // Insert Logic
        $title = mysqli_real_escape_string($conn, $_POST["title"]);
        $description = mysqli_real_escape_string($conn, $_POST["description"]);

        $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
        $result = mysqli_query($conn, $sql);

        if($result){ 
            $insert = true;
        }
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iNotes - Pro Task Manager</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <style>
        /* 1. BACKGROUND IMAGE CONFIGURATION */
        body {
            /* High quality office/workspace image */
            background: url('https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1920&auto=format&fit=crop') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }

        /* 2. DARK OVERLAY (Makes text readable) */
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5); /* 50% Black Overlay */
            z-index: -1;
        }
        
        /* Modern Navbar */
        .navbar { 
            background: rgba(102, 126, 234, 0.9); /* Slight transparency */
            backdrop-filter: blur(10px); /* Blur effect like iPhone */
        }
        .navbar-brand { font-weight: bold; font-size: 1.5rem; }
        
        /* Cards */
        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2); /* Stronger shadow for depth */
            background: rgba(255, 255, 255, 0.95); /* Slight transparency */
        }
        
        /* Form Inputs */
        .form-control {
            border-radius: 8px;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
        }
        .form-control:focus {
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            border-color: #667eea;
        }
        
        /* Buttons */
        .btn-primary {
            background-color: #667eea;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
        }
        .btn-primary:hover { background-color: #5a6fd6; }
    </style>
  </head>
  <body>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header border-0">
            <h5 class="modal-title fw-bold" id="editModalLabel">Edit Note</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="/todolist/index.php" method="POST">
            <div class="modal-body">
              <input type="hidden" name="snoEdit" id="snoEdit">
              <div class="mb-3">
                <label for="titleEdit" class="form-label text-secondary small fw-bold">TITLE</label>
                <input type="text" class="form-control" id="titleEdit" name="titleEdit">
              </div>
              <div class="mb-3">
                <label for="descriptionEdit" class="form-label text-secondary small fw-bold">DESCRIPTION</label>
                <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
              </div> 
            </div>
            <div class="modal-footer border-0">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="#"><i class="bi bi-journal-bookmark-fill me-2"></i>iNotes</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          
          <form class="d-flex ms-auto" role="search">
            <input class="form-control me-2 border-0" type="search" placeholder="Search notes..." aria-label="Search">
            <button class="btn btn-outline-light" type="submit">Search</button>
          </form>
        </div>
      </div>
    </nav>

    <?php
    if($insert){
        echo "<div class='alert alert-success alert-dismissible fade show shadow-sm rounded-0 mb-0' role='alert'>
        <strong>Success!</strong> Note added successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }
    if($delete){
        echo "<div class='alert alert-success alert-dismissible fade show shadow-sm rounded-0 mb-0' role='alert'>
        <strong>Success!</strong> Note deleted successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }
    if($update){
        echo "<div class='alert alert-success alert-dismissible fade show shadow-sm rounded-0 mb-0' role='alert'>
        <strong>Success!</strong> Note updated successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }
    ?>

    <div class="container my-5">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card-custom p-4 h-100">
                    <h4 class="mb-4 fw-bold text-secondary"><i class="bi bi-plus-circle-dotted me-2"></i>Add Note</h4>
                    <form action="/todolist/index.php" method="POST">
                        <div class="mb-3">
                            <label for="title" class="form-label small fw-bold text-secondary">NOTE TITLE</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="e.g. Groceries" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label small fw-bold text-secondary">DESCRIPTION</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Type details here..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold">Add Note</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card-custom p-4">
                    <h4 class="mb-4 fw-bold text-secondary"><i class="bi bi-list-task me-2"></i>Your Notes</h4>
                    <table class="table table-hover" id="myTable">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col" style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $sql = "SELECT * FROM `notes`";
                            $result = mysqli_query($conn, $sql);
                            $sno = 0;
                            while($row = mysqli_fetch_assoc($result)){
                                $sno = $sno + 1;
                                echo "<tr>
                                <th scope='row'>". $sno . "</th>
                                <td class='fw-bold'>". htmlspecialchars($row['title']) . "</td>
                                <td>". htmlspecialchars($row['description']) . "</td>
                                <td> 
                                    <button class='edit btn btn-sm btn-outline-primary me-1' id='".$row['sno']."'><i class='bi bi-pencil-fill'></i> Edit</button> 
                                    <button class='delete btn btn-sm btn-outline-danger' id='d".$row['sno']."'><i class='bi bi-trash-fill'></i></button> 
                                </td>
                                </tr>";
                            } 
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });

        // Edit Button Logic
        const edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                let tr = e.target.closest('tr');
                let title = tr.getElementsByTagName("td")[0].innerText;
                let description = tr.getElementsByTagName("td")[1].innerText;
                
                document.getElementById('titleEdit').value = title;
                document.getElementById('descriptionEdit').value = description;
                
                let btn = e.target.closest('button');
                document.getElementById('snoEdit').value = btn.id;
                
                let myModal = new bootstrap.Modal(document.getElementById('editModal'));
                myModal.show();
            })
        })

        // Delete Button Logic
        const deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                let btn = e.target.closest('button');
                let sno = btn.id.substr(1);

                if (confirm("Are you sure you want to delete this note?")) {
                    window.location = `/todolist/index.php?delete=${sno}`;
                }
            })
        })
    </script>
  </body>
</html>