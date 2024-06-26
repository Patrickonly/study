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
        <div><h1>Update import</h1></div>
   
    <div class="col-lg-6 mt-5">
        <form action="" method="post">
            <div class="mt-3">
                <label for="" class="label">furniture quantity to add or reduce</label>
                <input type="number" name="qty"  id="" class="form-control">
            </div>
            <div class="mt-3">
                <center>
                    <button name="add" class="btn btn-outline-success"><i class="fa fa-add"></i></button>
                    <button name="minus" class="btn btn-outline-success"><i class="fa fa-minus"></i></button>
                </center>
                
            </div>
            
        </form>
    </div> </center>
</div>
</body>
</html>

<?php 

if (isset($_POST["add"])) {
    $qty=$_POST["qty"];
    $id=$_GET['id'];
    $nqty=$qty+$_GET["qty"];
    $q="UPDATE import set quantity=:nqty where furnitureId=:id";
    $st=$con->prepare($q);
    if (!empty( $_POST["qty"])) {
        if ($st->execute(["nqty"=>$nqty,"id"=>$id])) {

            ?>
            <script>
                alert("record updated");
                window.location.href="home.php";
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


if (isset($_POST["minus"])) {
    $qty=$_POST["qty"];
    $id=$_GET['id'];
    $nqty=$_GET["qty"]-$qty;
    $q="UPDATE import set quantity=:nqty where furnitureId=:id";
    $st=$con->prepare($q);
    if (!empty( $_POST["qty"])) {
        if ($st->execute(["nqty"=>$nqty,"id"=>$id])) {

            ?>
            <script>
                alert("record updated");
                window.location.href="home.php";
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