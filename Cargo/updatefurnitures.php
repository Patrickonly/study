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
        <div><h1>Register new furniture</h1></div>
   
    <div class="col-lg-6 mt-5">
        <form action="" method="post">
            <div>
                <label for="" class="label">furniture name</label>
                <input type="text" value="<?php echo $_GET['funame']?>" name="funame" id="" class="form-control">
            </div>
            <div class="mt-3">
                <label for="" class="label">furniture owner</label>
                <input type="text" name="owner"  value="<?php echo $_GET['owner']?>" id="" class="form-control">
            </div>
            <div class="mt-3">
                <center>
                    <button name="update" class="btn btn-outline-success">Update</button>
                </center>
                
            </div>
            
        </form>
    </div> </center>
</div>
</body>
</html>

<?php 

if (isset($_POST["update"])) {
    $funame=$_POST["funame"];
    $owner=$_POST["owner"];
    $id=$_GET['id'];
    $q="UPDATE furniture set furnitureName=:funame,furnitureOwnerName=:ownerr where furnitureId=:id";
    $st=$con->prepare($q);
    if (!empty( $_POST["funame"] && $_POST["owner"] )) {
        if ($st->execute(["funame"=>$funame,"ownerr"=>$owner,"id"=>$id])) {

            ?>
            <script>
                alert("record updated");
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
    else{
        ?>
        <script>
            alert("fill all field");
        </script>
        <?php
    }
    
}

?>