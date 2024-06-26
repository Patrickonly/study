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
        <div><h1>Update export</h1></div>
   
    <div class="col-lg-6 mt-5">
        <form action="" method="post">
            <div class="mt-3">
                <label for="" class="label">furniture quantity reduce</label>
                <input type="number" name="qty"  id="" class="form-control">
            </div>
            <div class="mt-3">
                <center>
                    <button name="minus" class="btn btn-outline-success"><i class="fa fa-minus"></i></button>
                </center>
                
            </div>
            
        </form>
    </div> </center>
</div>
</body>
</html>

<?php 
if (isset($_POST["minus"])) {
    $qty=$_POST["qty"];
    $id=$_GET['id'];
    $nqty=$_GET["qty"]-$qty;
    if (!empty( $_POST["qty"])) {
        $q="UPDATE export set quantity=:nqty where furnitureId=:id";
        $st=$con->prepare($q);
        if ($st->execute(["nqty"=>$nqty,"id"=>$id])) {
            $q1="SELECT * from import where furnitureId='$id'";
            $st1=$con->prepare($q1);
            $st1->execute();
            $row=$st1->fetchAll(PDO::FETCH_ASSOC);
            $oldqty=$row[0]["quantity"];
            $newqty=$oldqty+$qty;
            $q2="UPDATE import set quantity=:newqty where furnitureId=:id";
            $st2=$con->prepare($q2);
            $st2->execute(["newqty"=>$newqty,"id"=>$id]);

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