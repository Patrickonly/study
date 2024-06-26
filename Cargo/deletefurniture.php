<?php 
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add furniture</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="css/all.css">
    <script src="js/all.js"></script>
</head>
<body>
<div class="container mt-5">
    <center>
        <div><h1>Are you sure you want to delete <?php echo $_GET["name"]?> ?</h1></div>
   
    <div class="col-lg-6 mt-5">
        <form action="" method="post" class="mt-5">
            <div class="mt-3">
                <center>
                    <a href="furnitures.php"  class="btn btn-outline-primary">Cancel</a>
                    <button name="delete" class="btn btn-outline-danger">Delete</button>
                </center>
                
            </div>
            
        </form>
    </div> </center>
</div>
</body>
</html>

<?php 

if (isset($_POST["delete"])) {
    $id=$_GET['id'];
    $q="DELETE FROM  furniture where furnitureId=:id";
    $st=$con->prepare($q);
  
        if ($st->execute(["id"=>$id])) {

            ?>
            <script>
                alert("furniture deleted now");
                window.location.href="furnitures.php";
            </script>
            <?php
    }
    else{
        ?>
        <script>
            alert("error occur");
        </script>
        <?php
    }
    }
?>