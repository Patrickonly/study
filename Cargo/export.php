<?php 
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>export</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="css/all.css">
    <script src="js/all.js"></script>
</head>
<body>
<div class="container mt-5">
    <center>
        <div><h1>Export furniture</h1></div>
    <div class="col-lg-6 mt-5">
        <form action="" method="post">
            <div>
                <label for="" class="label">Select furniture name</label>
                <?php
                $q="SELECT * from furniture";
                $st=$con->prepare($q);
                $st->execute(); 
                ?>
                <select name="furniturename" class="form-control">
                    <?php
                    while ($row=$st->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <option value="<?php echo $row["furnitureName"]?>"><?php echo $row["furnitureName"]?></option>
                        <?php
                        
                    }
                    
                    ?>
                </select>
            </div>
            <div class="mt-3">
                <label for="" class="label">Enter quantity in kgs</label>
                <input type="number" name="qty" id="" class="form-control">
            </div>
            <div class="mt-3">
                <center>
                    <button name="export" class="btn btn-outline-success">Export</button>
                </center>
                
            </div>
            
        </form>
    </div> </center>
</div>
</body>
</html>

<?php 

if (isset($_POST["export"])) {
    $funame=$_POST["furniturename"];
    $qty=$_POST["qty"];

    if (!empty( $_POST["furniturename"] && $_POST["qty"] )) {
        $q="SELECT * from furniture where furnitureName='$funame'";
        $st=$con->prepare($q);
        $st->execute(); 
        $row=$st->fetchAll(PDO::FETCH_ASSOC);
        $id=$row[0]["furnitureId"];

        $q2="SELECT SUM(quantity) as sm from import where furnitureId='$id'";
        $st2=$con->prepare($q2);
        $st2->execute(); 
        $row2=$st2->fetchAll(PDO::FETCH_ASSOC);
        $ttquantity=$row2[0]["sm"];

        $q3="SELECT * from export where furnitureId='$id'";
        $st3=$con->prepare($q3);
        $st3->execute(); 
        $row3=$st3->fetchAll(PDO::FETCH_ASSOC);
        if ($qty>$ttquantity) {
            ?>
            <script>
                alert("you have insufficient stock for this product");
            </script>
            <?php
        }else{
            $date=date('Y-m-d h:m:s');
            if (count($row3)>0) {
                $nqty=$qty+$row3[0]["quantity"];
                $qa="UPDATE export set exportDate=:datee,quantity=:nqty where furnitureId=:id";
                $sta=$con->prepare($qa);
                if ($sta->execute(["datee"=>$date,"nqty"=>$nqty,"id"=>$id])) {
                    $nqtyimport=$row2[0]["sm"]-$qty;
                    $qx="UPDATE import set quantity=:nqty where furnitureId=:id";
                    $stx=$con->prepare($qx);
                    $stx->execute(["nqty"=>$nqtyimport,"id"=>$id]);
        
                    ?>
                    <script>
                        alert("furniture exported");
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
                $q="INSERT into export values('$id',:dt,:qty)";
                $st=$con->prepare($q);
                if ($st->execute(["dt"=>$date,"qty"=>$qty])) {
                    $nqtyimport=$row2[0]["sm"]-$qty;
                    $qx="UPDATE import set quantity=:nqty where furnitureId=:id";
                    $stx=$con->prepare($qx);
                    $stx->execute(["nqty"=>$nqtyimport,"id"=>$id]);
        
                    ?>
                    <script>
                        alert("furniture exported");
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