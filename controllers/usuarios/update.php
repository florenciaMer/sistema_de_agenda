<?php
include_once('../config.php');

$id_usuario = $_POST['id_usuario'];
$email = $_POST['email'];
$estado = 1;
$password_user = $_POST['password_user'];
$password_repeat = $_POST['password_repeat'];

if ($password_user != $password_repeat) {
    session_start();
    $_SESSION['mensaje'] = 'Las contraseñas no coinciden';
    $_SESSION['icono'] = 'error';
    ?>
    <script>
        window.history.back();
    </script>
<?php
}else{
$sentencia= $pdo->prepare("SELECT * FROM tb_usuarios  
    where id_usuario != :id_usuario 
    AND email = :email
    AND estado = :estado");

$sentencia->bindParam(':id_usuario', $id_usuario);
$sentencia->bindParam(':email', $email);
$sentencia->bindParam(':estado', $estado);

$sentencia->execute();
$cuenta = $sentencia->rowCount();

if ($cuenta>0) {
    session_start();
    $_SESSION['mensaje'] = 'Ese email ya existe en la base de datos';
    $_SESSION['icono'] = 'error';
    ?>
    <script>
        window.history.back();
    </script>
<?php

}else{
    
    $password_user = password_hash($password_user, PASSWORD_DEFAULT);

    $sentencia2 = $pdo->prepare("UPDATE tb_usuarios SET 
    email = :email,
    estado = :estado,
    password_user = :password_user,
    fyh_actualizacion = :fyh_actualizacion
    WHERE id_usuario = :id_usuario
");

$sentencia2->bindParam(':id_usuario', $id_usuario);
$sentencia2->bindParam(':email', $email);
$sentencia2->bindParam(':estado', $estado);
$sentencia2->bindParam(':password_user', $password_user);
$sentencia2->bindParam(':fyh_actualizacion', $fechaHora);
 
 if ($sentencia2->execute()) {
 
    session_start();
    $_SESSION['mensaje'] = 'El usuario se actualizo de la manera correcta';
    $_SESSION['icono'] = 'success';
    ?>
    <script> location.href = "<?php echo APP_URL; ?>/view/usuarios/index.php"</script>
<?php 
 }
}?>


<?php } ?>