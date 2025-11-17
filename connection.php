<?php
$servername = "localhost";
$database = "estoque_alpha_suplementos";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password, $database);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


