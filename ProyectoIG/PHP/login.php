<?php
session_start();
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $id_rol_formulario = (int)$_POST['id_rol'];

    // 1. Validar campos vacíos
    if (empty($correo) || empty($password) || empty($id_rol_formulario)) {
        header("Location: index.php?error=vacios");
        exit();
    }

    try {
        // Buscar al usuario por correo
        $stmt = $pdo->prepare("SELECT id_usuario, nombre, password_hash, id_rol FROM usuarios WHERE correo = ?");
        $stmt->execute([$correo]);
        $usuario = $stmt->fetch();

        // Verificar existencia de usuario y contraseña
        if ($usuario && password_verify($password, $usuario['password_hash'])) {
            
            if ($usuario['id_rol'] === $id_rol_formulario) {
                session_regenerate_id();
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['id_rol'] = $usuario['id_rol'];

                switch ($usuario['id_rol']) {
                    case 1: header("Location: dashboard_cliente.php"); break;
                    case 2: header("Location: dashboard_mecanico.php"); break;
                    case 3: header("Location: dashboard_dueno.php"); break;
                }
                exit();
            } else {
                header("Location: index.php?error=credenciales");
                exit();
            }
        } else {
            header("Location: index.php?error=credenciales");
            exit();
        }
    } catch (PDOException $e) {
        die("Error de conexión, por favor intenta más tarde."); 
    }
} else {
    header("Location: index.php");
    exit();
}
?>