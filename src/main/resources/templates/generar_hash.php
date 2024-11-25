<!-- Generar hash de contraseña
 Este archivo dr puede utilizar para obtener el hash
 de una contraseña que luego se puede insetar en la  base de datos -->

<!-- Se debe guardar este archivo fuera de la carpeta privada 
 para poder encontrarlo y utilizarlo cuando se necesite en el host local-->
<?php
$contrasena = 'Contraseña123';
$contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
echo $contrasena_hash;
?>