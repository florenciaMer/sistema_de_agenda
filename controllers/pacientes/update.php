<?php
include_once('../config.php');

$id_paciente = $_POST['id_paciente'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$celular = $_POST['celular'];
$email = $_POST['email'];
$fyh_actualizacion =$fechaHora;
$estado = 1;
$cuenta = 0;

/*$sentencia= $pdo->prepare("SELECT * FROM tb_turnos  
    where id_usuario != :id_usuario 
    AND email = :email
    AND estado = :estado");

$sentencia->bindParam(':id_usuario', $id_usuario);
$sentencia->bindParam(':email', $email);
$sentencia->bindParam(':estado', $estado);

$sentencia->execute();
$cuenta = $sentencia->rowCount();
*/
if ($cuenta>0) {
    session_start();
    $_SESSION['mensaje'] = 'Ese paciente tiene turnos proximos en el sistema';
    $_SESSION['icono'] = 'error';
    ?>
    <script>
        window.history.back();
    </script>
<?php

}else{
    
    $sentencia = $pdo->prepare("SELECT * FROM tb_pacientes WHERE 
    id_paciente != :id_paciente AND
    email =:email OR nombre =:nombre AND apellido =:apellido");

    $sentencia->bindParam('id_paciente', $id_paciente);
    $sentencia->bindParam('nombre', $nombre);
    $sentencia->bindParam('apellido', $apellido);
    $sentencia->bindParam('email', $email);

    $sentencia->execute();
    $cuenta = $sentencia->rowCount();

    if ($cuenta>0) {
        session_start();
        $_SESSION['mensaje'] = 'Ya existe un usuario con ese nombre y apellido o email en la base de datos';
        $_SESSION['icono'] = 'error';
        ?>
        <script>
            window.history.back();
        </script>
     
<?php }else{

    $sentencia2 = $pdo->prepare("UPDATE tb_pacientes SET 
    id_paciente = :id_paciente,
    nombre = :nombre,
    apellido = :apellido,
    direccion = :direccion,
    telefono = :telefono,
    celular = :celular,
    email = :email,
    fyh_actualizacion = :fyh_actualizacion,
    estado = :estado,
    fyh_actualizacion = :fyh_actualizacion
    WHERE id_paciente = :id_paciente
");

$sentencia2->bindParam(':id_paciente', $id_paciente);
$sentencia2->bindParam(':nombre', $nombre);
$sentencia2->bindParam(':apellido', $apellido);
$sentencia2->bindParam(':direccion', $direccion);
$sentencia2->bindParam(':telefono', $telefono);
$sentencia2->bindParam(':celular', $celular);
$sentencia2->bindParam(':email', $email);
$sentencia2->bindParam(':fyh_actualizacion', $fechaHora);
$sentencia2->bindParam(':estado', $estado);
 
 if ($sentencia2->execute()) {

$sql_check = "SELECT * FROM tb_reservas 
            WHERE id_paciente = :id_paciente";

$sentencia = $pdo->prepare($sql_check);
$sentencia->bindParam(':id_paciente', $id_paciente);

$sentencia->execute();


$reservas_datos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$cuenta = $sentencia->rowCount();
 if ($cuenta > 0) { //existe un paciente que cambio su nombre o apellido en la tabla de reservas
    //echo "existe paciente en la tabla de reservas";
    foreach ($reservas_datos as $reserva) {
        $id_reserva = $reserva['id_reserva'];
        $hora_cita = $reserva['hora_cita'];
        $title = $hora_cita.'-'. $nombre . '-' . $apellido;
    $sentencia2 = $pdo->prepare("UPDATE tb_reservas SET 
    title = :title,
    fyh_actualizacion = :fyh_actualizacion
    WHERE id_reserva = :id_reserva");
    $sentencia2->bindParam(':id_reserva', $id_reserva);
    $sentencia2->bindParam(':title', $title);
    $sentencia2->bindParam(':fyh_actualizacion', $fechaHora);
    $sentencia2->execute();
    echo "todos los cambios se realizaron";
    }
 }
    session_start();
    $_SESSION['mensaje'] = 'El Paciente se actualizo de la manera correcta y se actualizo en agenda';
    $_SESSION['icono'] = 'success';
    ?>
    <script> location.href = "<?php echo APP_URL; ?>/view/pacientes/index.php"</script>
<?php 
 }
}
}?>


