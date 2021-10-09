<!-- 
  INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, 'Get snacks', 'please buy some snacks from the shop, I\'m hungry :) ', current_timestamp()); 

-->


<!-- connecting to the database -->
<?php
    $servername = "localhost";
    $username = "root";
    $password = ""; //default password
    $database = "notes";

    $insert_flag = false;

    $conn = mysqli_connect($servername, $username, $password, $database);

    if(!$conn){
        die("Sorry, failed to connect".mysqli_connect_error());
    }
    // else{
    //     echo "Successfully connected :)";
    // }
    // echo $_POST['snoedit'];

    //  if(isset($_POST['snoEdit'])){
    //   //Update the record 
    //   echo "yes";
    //    exit();
    //  }

     if(isset($_GET['delete'])){
       $sno = $_GET['delete'];
       

       $sql = "DELETE FROM `notes` WHERE `notes`.`sno` = $sno";
       mysqli_query($conn, $sql);
     }
        
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

      if(isset($_POST['snoEdit'])){
        //Update the record 
        $sno = $_POST['snoEdit'];
        $title = $_POST['titleEdit'];
      $description = $_POST['descriptionEdit'];

      $sql = "UPDATE `notes` SET  `title` = '$title', `description` = '$description' WHERE `notes`.`sno` = $sno";

      $result = mysqli_query($conn, $sql);

       }
       else{
        //insert
      $title = $_POST['title'];
      $description = $_POST['description'];

      $sql = "INSERT INTO `notes` ( `title`, `description`) VALUES ( '$title', '$description')";

      $result = mysqli_query($conn, $sql);

      if($result){
        // echo "Inserted :)";
        $insert_flag = true;
      }
      else{
        echo "Not inserted :(";
      }
    }
    }
  
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">

    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <script>
      $(document).ready( function () {
        $('#myTable').DataTable();
      });
    </script>

    <title>CRUD app in PHP</title>

  
  </head>
  <body>
    
    <!-- edit modal -->

    <!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  Edit modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="/PHPTutes/crud/index.php" method="post">
      <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="mb-3">
              <label for="title" class="form-label">Enter the title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
              
            </div>
            <div class="form-floating">
                <textarea class="form-control" placeholder="Leave a comment here" id="descriptionEdit" name="descriptionEdit"></textarea>
                <label for="floatingTextarea">Description</label>
              </div>
           
            <button type="submit" class="btn btn-primary my-4">Update note</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


    <!-- code for alert   -->

    <?php
      if($insert_flag == true){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success :)</strong> Your record has been inserted.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
      }
    ?>

    
    <div class="container my-5">
        <h2>Add a note</h2>
        <form action="/PHPTutes/crud/index.php" method="post">
            <div class="mb-3">
              <label for="title" class="form-label">Enter the title</label>
              <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
              
            </div>
            <div class="form-floating">
                <textarea class="form-control" placeholder="Leave a comment here" id="description" name="description"></textarea>
                <label for="floatingTextarea">Description</label>
              </div>
           
            <button type="submit" class="btn btn-primary my-4">Add Note</button>
          </form>
    </div>


    <div class="container">
        


          <!-- table -->

          <table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">S no.</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php
          $sql = "SELECT * FROM `notes` ";

          $result = mysqli_query($conn, $sql);
          $no_of_rows = mysqli_num_rows($result);
          if($no_of_rows > 0){
              while($row = mysqli_fetch_assoc($result)){
              
                echo "<tr>
                <th scope='row'> ".$row['sno']." </th>
                <td>".$row['title']."</td>
                <td>".$row['description']."</td>
                <td><button class='edit btn btn-sm btn-primary' id=" .$row['sno']. ">Edit</button> <button class='delete btn btn-sm btn-primary'  id=d" .$row['sno']. ">Delete</button>
              </tr>";
              echo "<br>";
              
                // echo  $row['sno'] . ")" . $row['title']. "," .  $row['description'];
              
            }
          }
        ?>
        <!-- <a href='/del'>Delete</a> <a href='/edit'></a> -->
  
  
 
   
  </tbody>
</table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.min.js" integrity="sha384-PsUw7Xwds7x08Ew3exXhqzbhuEYmA2xnwc8BuD6SEr+UmEHlX8/MCltYEodzWA4u" crossorigin="anonymous"></script>
    -->

    <script>
    let edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element)=>{
        element.addEventListener("click", (e)=>{
            console.log('edit', );
            tr = e.target.parentNode.parentNode;
            title = tr.getElementsByTagName("td")[0].innerText;
            description = tr.getElementsByTagName("td")[1].innerText;
            console.log(title, description);

            titleEdit.value = title;
            descriptionEdit.value = description;
            snoEdit.value = e.target.id;
            console.log(e.target.id);
            $('#editModal').modal('toggle');
        })
    })


    //For deleting

    let deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element)=>{
        element.addEventListener("click", (e)=>{
            console.log('edit', );
            sno = e.target.id.substr(1,)
            
            if(confirm("Choose an option")){
              console.log("Yes");
              window.location = `/PHPTutes/crud/index.php?delete=${sno}`;
            }
            else{
              console.log("No");
            }
            
        })
    })
  </script>
  </body>

  
  
</html>
