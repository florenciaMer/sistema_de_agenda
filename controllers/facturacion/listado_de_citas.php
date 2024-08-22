<?php

//include_once('../config.php');

/*$sql = "SELECT * FROM tb_reservas WHERE estado = '1' 
INNER JOIN tb
ORDER BY fecha_cita DESC";*/
$sql  = "SELECT 
    r.*, 
    v.precio 
FROM 
    tb_reservas r
LEFT JOIN 
    tb_valores v
ON 
    r.id_paciente = v.id_paciente_valor 
    AND r.fecha_cita BETWEEN v.desde AND v.hasta
WHERE 
    r.estado = '1' 
ORDER BY 
    r.fecha_cita DESC";



$query = $pdo->prepare($sql);
$query->execute();

$citas_datos = $query->fetchAll(PDO::FETCH_ASSOC);
?>