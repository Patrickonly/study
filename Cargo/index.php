<?php 

session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="css/all.css">
    <script src="js/all.js"></script>
</head>
<body>
<div class="container mt-5">
    <center>
        <div><h1>login into your account</h1></div>
   
    <div class="col-lg-6 mt-5">
        <form action="" method="post">
            <div>
                <label for="" class="label"><i class="fa fa-user"></i>Enter username</label>
                <input type="text" name="uname" id="" class="form-control">
            </div>
            <div class="mt-3">
                <label for="" class="label"><i class="fa fa-key"></i>Enter password</label>
                <input type="password" name="pass" id="" class="form-control">
            </div>
            <div class="mt-3">
                <center>
                    <button name="go" class="btn btn-outline-success">Go</button>
                </center>
                
            </div>
            
        </form>
    </div> </center>
</div>
</body>
</html>

<?php 

if (isset($_POST["go"])) {
    $con=new PDO("mysql:host=localhost;dbname=cargo","root","");
    $uname=$_POST["uname"];
    $pass=$_POST["pass"];
    $q="SELECT * from manager where username=:uname";
    $st=$con->prepare($q);
    $st->execute(["uname"=>$uname]);
    $row=$st->fetchAll(PDO::FETCH_ASSOC);
    if (count($row)>0) {
        $passw=$row[0]["password"];
        if ($passw==$pass) {
            $_SESSION["user"]=$row[0]["username"];
            ?>
            <script>
                window.location.href="home.php";
            </script>
            <?php
        }
        else{
            ?>
            <script>
                alert("invalid credentials");
            </script>
            <?php
        }
    }
    else{
        ?>
        <script>
            alert("unkown user");
        </script>
        <?php
    }
}

?>