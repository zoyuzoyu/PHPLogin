
<?php
define(BR,"</br>");

$user = 'root';
$password = 'root';
$db = 'phplogin';
$host = 'localhost';
$port = 8889;

// $link = mysqli_init();
// $success = mysqli_real_connect(
//    $link, 
//    $host, 
//    $user, 
//    $password, 
//    $db,
//    $port
// );
// mysqli_close();

$link = mysqli_connect(
   "$host:$port", 
   $user, 
   $password
);

if (mysqli_connect_errno()) {
    die('Could not connect: ' . mysqli_connect_error());
    exit();
}
echo "connect success"."</br>";


//创建DATABASE
if (mysqli_query($link,"CREATE DATABASE ".$db)) {
    echo "Database created"."</br>";
} else {
    echo "Database create fail"."</br>";
}


$db_selected = mysqli_select_db(
    $link,
    $db
);


$sql = "CREATE TABLE Persons (
    FirstName varchar(15),
    LastName varchar(15),
    Age int
)";

$result = mysqli_query($link,$sql);
if ($result) {
    echo "create table persons "."success"."</br>";
} else {
    echo "create table persons "."fail. "."Error: ".mysqli_error($link).BR;;
}


mysqli_query($link,"INSERT INTO Persons (FirstName, LastName, Age) 
    VALUES ('Peter', 'Griffin', '35')");

mysqli_query($link,"INSERT INTO Persons (FirstName, LastName, Age) 
    VALUES ('Glenn', 'Quagmire', '33')");


echo "close mysql";
mysqli_close($link);
?>

