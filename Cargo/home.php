
<?php 
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
</head>
<body>
<div class="container-fluid">
    <div class="row  shadow-lg px-5 py-5">
        <div class="col-lg-6">
            <div>
                <div class="col-lg-5 shadow  bg-info px-3 py-1 rounded-5">
                    <h5>List of imports</h5>
                </div>
                <div class="mt-2">
                    <?php
                    $q="SELECT import.importDate,import.furnitureId,import.quantity,furniture.furnitureName,furniture.furnitureOwnerName from import,furniture where furniture.furnitureId=import.furnitureId";
                    $st=$con->prepare($q);
                    $st->execute();

                        ?>
                        <div class="shadow-lg" style="width: 100%;height:400px;overflow:auto">

                        
                        <table class="table">
                            <tr>
                                <th>imported date</th>
                                <th>furniture name</th>
                                <th>furniture owner</th>
                                <th>quantity</th>
                                <th>action</th>
                            </tr>
                        
                        <?php
                   
                    while ($row=$st->fetch(PDO::FETCH_ASSOC)) {

                        ?>
                        <tr>
                            <td><?php echo $row["importDate"]?></td>
                            <td><?php echo $row["furnitureName"]?></td>
                            <td><?php echo $row["furnitureOwnerName"]?></td>
                            <td><?php echo $row["quantity"]?></td>
                            <td>
                                <a href='updateimport.php?id=<?php echo $row["furnitureId"]?>&qty=<?php echo $row["quantity"]?>' class="btn btn-outline-secondary"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                        <?php
                        
                    } 
                
                    ?>
            </table>
            </div>
            </div>
            </div>
          
        </div>
        <div class="col-lg-6">
        <div class="col-lg-5 shadow  bg-info px-3 py-1 rounded-5">
                    <h5>List of exports</h5>
                </div>
                <div class="mt-2">
            <?php
                    $q="SELECT export.exportDate,export.furnitureId,export.quantity,furniture.furnitureName,furniture.furnitureOwnerName from export,furniture where furniture.furnitureId=export.furnitureId";
                    $st=$con->prepare($q);
                    $st->execute();
                        ?>
                        <div class="shadow-lg" style="width: 100%;height:400px;overflow:auto">
                        <table class="table">
                            <tr>
                                <th>exported date</th>
                                <th>furniture name</th>
                                <th>furniture owner</th>
                                <th>quantity</th>
                                <th>action</th>
                            </tr>
                        <?php
                    
                    while ($row=$st->fetch(PDO::FETCH_ASSOC)) {

                        ?>
                        <tr>
                            <td><?php echo $row["exportDate"]?></td>
                            <td><?php echo $row["furnitureName"]?></td>
                            <td><?php echo $row["furnitureOwnerName"]?></td>
                            <td><?php echo $row["quantity"]?></td>
                            <td>
                                <a href='updateexport.php?id=<?php echo $row["furnitureId"]?>&qty=<?php echo $row["quantity"]?>' class="btn btn-outline-secondary"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                        <?php
                        
                    } 

                    ?>
            </table>
            </div>
             </div>
        </div>
        
        <div class="row">
        <center>
            <div class="col-lg-9 mt-3 py-2 shadow-lg">
                <div class="col-lg-5 mt-3 shadow  bg-info px-3 py-1 rounded-5">
                    <h5>Current stock</h5>
                </div>
                <div class="mt-2">
                    <?php
                    $q="SELECT import.importDate,import.quantity,furniture.furnitureName,furniture.furnitureOwnerName from import,furniture where furniture.furnitureId=import.furnitureId and import.quantity>0";
                    $st=$con->prepare($q);
                    $st->execute();

                        ?>
                        <div class="shadow-lg" style="width: 100%;height:400px;overflow:auto">

                        
                        <table class="table">
                            <tr>
                                <th>furniture name</th>
                                <th>furniture owner</th>
                                <th>quantity</th>
                            </tr>
                        
                        <?php
                   
                    while ($row=$st->fetch(PDO::FETCH_ASSOC)) {

                        ?>
                        <tr>
                            <td><?php echo $row["furnitureName"]?></td>
                            <td><?php echo $row["furnitureOwnerName"]?></td>
                            <td><?php echo $row["quantity"]?></td>
                        </tr>
                        <?php
                        
                    } 
                
                    ?>
            </table>
            </div>
            </div>
            </div>
        </center>
        </div>
    
    </div>

    

</div>
    


</body>
</html>