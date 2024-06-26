
<?php
session_start(); 
if (!isset($_SESSION["user"])) {
    ?>
    <script>
        window.location.href="index.php";
    </script>
    <?php
}
$con=new PDO("mysql:host=localhost;dbname=cargo","root","");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="css/all.css">
    <script src="js/all.js"></script>
    <style>
    </style>
</head>
<body>
    <form action="" method="post">
    <div class="d-flex flex-row py-3">
        <div class="col-lg-2 px-3">
            <a href="home.php"><img src="logo.png" alt="no photo" width="50" height="40"></a>
        </div>
        <div class="col-lg-5 text-center">
           <b>CARGO ltd</b> 
        </div>
        <div class="col-lg-5">
            <div class="float-end mx-3">
                <a href="addnewmanager.php" class="btn btn-outline-secondary">add new manager</a>
                
                    <button name="out" class="btn btn-outline-secondary">logout</button>
                
            </div>
             
        </div>
    </div>
    </form>
    <div class="row bg-dark py-1 px-5 shadow">
        <div class="col-lg-2">
            <a href="home.php" class="text-decoration-none text-white"><i class="fa fa-home"></i> Home</a>
        </div>
        <div class="col-lg-2">
            <a href="import.php" class="text-decoration-none text-white"><i class="fa fa-file-import"></i> import</a>
        </div>
        <div class="col-lg-2">
            <a href="export.php" class="text-decoration-none text-white"><i class="fa fa-remove"></i> Export</a>
        </div>
        <div class="col-lg-2">
            <a href="furnitures.php" class="text-decoration-none text-white">Furnitures</a>
        </div>
    </div>
</body>
</html>

<?php 
if (isset($_POST["out"])) {
    session_destroy();
    ?>
    <script>
        window.location.href="index.php";
    </script>
    <?php
}
?>