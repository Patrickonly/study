<?php


if (isset($_POST["upl"])) {
    $image="./imgs/".basename($_FILES["photo"]["name"]);
    $arr1=explode(".",$image);
    $arr=["png","jpg","pdf","css","gif"];
    // if (array_search($ext,$arr)) {
    //    move_uploaded_file($_FILES["photo"]["tmp_name"],$image); 
    //    echo "yes";
    // }
    // else{
    //     echo "noooo";
    // }
    echo $arr1[count($arr1)-1];
    

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="photo" id="">
        <button name="upl">upload</button>
    </form>
</body>
</html>