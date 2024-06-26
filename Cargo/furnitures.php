
<?php 
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>furnitures</title>
</head>
<body>

<div class="container-fluid">
    <div class="row px-5 py-5">
        
        
        <div class="row">
        <center>
            <div class="col-lg-9 mt-3 py-2 shadow-lg">
                <div class="alert alert-heading col-lg-5 mt-3 px-3 py-1 ">
                    <h5>Furnitures registered for stock</h5>
                </div>
                <div class="mt-2">
                    <?php
                    $q="SELECT * from furniture";
                    $st=$con->prepare($q);
                    $st->execute();

                        ?>
                        <div class="col-lg-3 float-end">
                            <a href="addfurniture.php"><button class="btn btn-outline-info"><i class="fa fa-add fa-2x"></i> Register new</button></a>
                        </div>
                        <div class="" style="width: 100%;height:400px;overflow:auto">
                        <table class="table">
                            <tr>
                                <th>furniture name</th>
                                <th>furniture owner</th>
                                <th>action</th>
                
                                
                            </tr>
                        
                        <?php
                   
                    while ($row=$st->fetch(PDO::FETCH_ASSOC)) {

                        ?>
                        <tr>
                            <td><?php echo $row["furnitureName"]?></td>
                            <td><?php echo $row["furnitureOwnerName"]?></td>
                            <td>
                                <a href="updatefurnitures.php?funame=<?php echo $row['furnitureName']?>&owner=<?php echo $row['furnitureOwnerName']?>&id=<?php echo $row['furnitureId']?>"><button class="btn btn-secondary"><i class="fa fa-edit"></i></button></a>
                                <a href="deletefurniture.php?id=<?php echo $row['furnitureId']?>&name=<?php echo $row['furnitureName']?>"><button class="btn btn-danger"><i class="fa fa-trash"></i></button></a>
                            </td>
                        </tr>
                        <?php
                        
                    } 
                
                    ?>
            </table>
            </div>
            </div>
        </center>
        </div>
    
    </div>

    

</div>
    


</body>
</html>