<?php

define('SERVIDOR', 'localhost');
define('USUARIO', 'root');
define('PASSWORD', '');
define('BD', 'agenda');

define('APP_NAME', 'SIS | Agenda');
define('APP_URL', 'http://localhost/agenda');
define('KEY_API_MAPS', '');

 /** @var string $servidor */
$servidor = "mysql:dbname=".BD.";host=".SERVIDOR;
try {
    $pdo = new PDO($servidor, USUARIO, PASSWORD, 
    array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
   // echo "Conexion exitosa a la base de datos";
} catch (PDOException $e) {
    echo "Error en la conexion a la base de datos .$e";
}

date_default_timezone_set('America/Argentina/Buenos_Aires');
$fechaHora = date('Y-m-d H:i:s');

$fechaActual = date('Y-m-d');
$diaActual = date('d');
$mes = date('m');
$anio = date('Y');
$estado_de_registro = 1;


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agenda";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>