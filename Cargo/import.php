<?php 
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>import</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="css/all.css">
    <script src="js/all.js"></script>
</head>
<body>
<div class="container mt-5">
    <center>
        <div><h1>Import furniture</h1></div>
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
                    <button name="import" class="btn btn-outline-success">Import</button>
                </center>
                
            </div>
            
        </form>
    </div> </center>
</div>
</body>
</html>

<?php 

if (isset($_POST["import"])) {
    $funame=$_POST["furniturename"];
    $qty=$_POST["qty"];

    if (!empty( $_POST["furniturename"] && $_POST["qty"] )) {
        $q="SELECT * from furniture where furnitureName='$funame'";
        $st=$con->prepare($q);
        $st->execute(); 
        $row=$st->fetchAll(PDO::FETCH_ASSOC);
        $id=$row[0]["furnitureId"];
        $q2="SELECT * from import  where furnitureId=:id";
        $st2=$con->prepare($q2);
        $st2->execute(["id"=>$id]); 
        $row2=$st2->fetchAll(PDO::FETCH_ASSOC);
        $date=date('Y-m-d h:m:s');
        if (count($row2)<1){
            $q3="INSERT into import values('$id',:dt,:qty)";
            $st3=$con->prepare($q3);
            if ($st3->execute(["dt"=>$date,"qty"=>$qty])) {
    
                ?>
                <script>
                    alert("furniture imported");
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
            $nqty=$qty+$row2[0]["quantity"];
            $q4="UPDATE import set quantity=:qty,importDate=:dt where furnitureId=:id";
            $st4=$con->prepare($q4);
            if ($st4->execute(["dt"=>$date,"qty"=>$nqty,"id"=>$id])) {
    
                ?>
                <script>
                    alert("furniture imported");
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
      else{
        ?>
        <script>
            alert("fill all field");
        </script>
        <?php
    }
    }
  
    

?>