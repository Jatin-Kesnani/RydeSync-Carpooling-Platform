<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "rydesync";

$conn = mysqli_connect($server, $username, $password, $database);

if($conn)
{
//    echo "Sucess";
}
else 
    die ("Error". mysqli_conect_error());

?>