<?php
session_start();
require 'conexion.php'; // Llamamos a tu archivo de conexión

// Validar que el usuario que intenta hacer esto sea realmente un dueño (Rol 3)
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 3) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Identificamos qué acción viene del formulario (crear, modificar o eliminar)
    $accion = $_POST['accion'] ?? '';

    try {
        if ($accion === 'crear') {
            // Recoger y limpiar datos
            $nombre = trim($_POST['nombre']);
            $correo = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            $id_rol = (int)$_POST['id_rol'];

            // Encriptar la contraseña (vital para la seguridad)
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Insertar en la base de datos
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, password_hash, id_rol) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nombre, $correo, $password_hash, $id_rol]);

            header("Location: dashboard_dueno.php?msg=creado");
            exit();

        } elseif ($accion === 'modificar') {
            $id_usuario_target = (int)$_POST['id_usuario_target'];
            
            // Recoger datos opcionales
            $nuevo_nombre = trim($_POST['nuevo_nombre']);
            $nuevo_correo = filter_var(trim($_POST['nuevo_correo']), FILTER_SANITIZE_EMAIL);
            $nueva_password = $_POST['nueva_password'];
            $nuevo_rol = !empty($_POST['nuevo_rol']) ? (int)$_POST['nuevo_rol'] : null;

            // Arreglos para construir una consulta dinámica (solo actualiza lo que el dueño llenó)
            $updates = [];
            $params = [];

            if (!empty($nuevo_nombre)) {
                $updates[] = "nombre = ?";
                $params[] = $nuevo_nombre;
            }
            if (!empty($nuevo_correo)) {
                $updates[] = "correo = ?";
                $params[] = $nuevo_correo;
            }
            if (!empty($nueva_password)) {
                $updates[] = "password_hash = ?";
                $params[] = password_hash($nueva_password, PASSWORD_DEFAULT);
            }
            if (!empty($nuevo_rol)) {
                $updates[] = "id_rol = ?";
                $params[] = $nuevo_rol;
            }

            // Si se llenó al menos un campo, ejecutamos el UPDATE
            if (count($updates) > 0) {
                $sql = "UPDATE usuarios SET " . implode(", ", $updates) . " WHERE id_usuario = ?";
                $params[] = $id_usuario_target;
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);
            }

            header("Location: dashboard_dueno.php?msg=modificado");
            exit();

        } elseif ($accion === 'eliminar') {
            $id_usuario_target = (int)$_POST['id_usuario_target'];

            // Medida de seguridad: Evitar que el dueño borre su propia cuenta por accidente
            if ($id_usuario_target === $_SESSION['id_usuario']) {
                header("Location: dashboard_dueno.php?error=autoeliminar");
                exit();
            }

            $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
            $stmt->execute([$id_usuario_target]);

            header("Location: dashboard_dueno.php?msg=eliminado");
            exit();
        }
    } catch (PDOException $e) {
        // En caso de error (por ejemplo, si el correo ya existe y es unique)
        die("Error en la base de datos: " . $e->getMessage());
    }
} else {
    header("Location: dashboard_dueno.php");
    exit();
}
?>