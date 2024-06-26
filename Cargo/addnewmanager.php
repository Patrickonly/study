<?php 
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>new user</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="css/all.css">
    <script src="js/all.js"></script>
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-6">
            <div>
                <h5>List of managers</h5>
            </div>
            <div>
            <div class="mt-5">
                    <?php
                    $q="SELECT * from manager";
                    $st=$con->prepare($q);
                    $st->execute();

                        ?>
                        <div class="" style="width: 100%;height:400px;overflow:auto">
                        <table class="table">
                            <tr>
                                <th>username</th>
                                <th>password</th>
                                <th>action</th>
                
                                
                            </tr>
                        
                        <?php
                   
                    while ($row=$st->fetch(PDO::FETCH_ASSOC)) {

                        ?>
                        <tr>
                            <td><?php echo $row["username"]?></td>
                            <td><?php echo $row["password"]?></td>
                            <td>
                                <a href="updateuser.php?uname=<?php echo $row['username']?>&upass=<?php echo $row['password']?>&id=<?php echo $row['managerId']?>"><button class="btn btn-secondary"><i class="fa fa-edit"></i></button></a>
                                <a href="deleteuser.php?id=<?php echo $row['managerId']?>&uname=<?php echo $row['username']?>"><button class="btn btn-danger"><i class="fa fa-trash"></i></button></a>
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
                <center>
            <div><h5>ADD NEW MANAGER</h5></div>
            <div class="col-lg-6 mt-5">
                <form action="" method="post">
                    <div>
                        <label for="" class="label">User name</label>
                        <input type="text" name="user" id="" class="form-control">
                    </div>
                    <div class="mt-3">
                        <label for="" class="label">Password</label>
                        <input type="password" name="pass" id="" class="form-control">
                    </div>
                    <div class="mt-3">
                        <label for="" class="label">confirm Password</label>
                        <input type="password" name="cpass" id="" class="form-control">
                    </div>
                    <div class="mt-3">
                        <center>
                            <button name="add" class="btn btn-outline-success">Add</button>
                        </center>
                        
                    </div>
                    
                </form>
            </div> </center>
        </div>
    </div>
</div>
</body>
</html>

<?php 

if (isset($_POST["add"])) {
    $uname=$_POST["user"];
    $upass=$_POST["pass"];
    $cupass=$_POST["cpass"];

    if (!empty( $_POST["user"] && $_POST["pass"]&& $_POST["cpass"] )) {
        $q="SELECT * from manager where username='$uname'";
        $st=$con->prepare($q);
        $st->execute(); 
        $row=$st->fetchAll(PDO::FETCH_ASSOC);
        if (count($row)>0){
      
            ?>
            <script>
                alert("this username was taken");
            </script>
            <?php
        }
        else{
            if ($upass==$cupass) {
                $q3="INSERT into manager values('',:us,:pass)";
                $st3=$con->prepare($q3);
                if ($st3->execute(["us"=>$uname,"pass"=>$upass])) {
        
                    ?>
                    <script>
                        alert("user created");
                    </script>
                    <?php
            }
        }
        else{
            ?>
            <script>
                alert("password no match");
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