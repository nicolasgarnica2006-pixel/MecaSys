

<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 3) {
    header("Location: ../index.php"); 
    exit();
}
?>
<?php
session_start();
require 'conexion.php'; // Añadimos la conexión aquí para poder consultar usuarios

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 3) {
    header("Location: ../index.php"); 
    exit();
}

// Consultar la base de datos para obtener todos los usuarios y mostrarlos en el select
try {
    $stmtUsuarios = $pdo->query("SELECT id_usuario, nombre, correo, id_rol FROM usuarios ORDER BY nombre ASC");
    $listaUsuarios = $stmtUsuarios->fetchAll();
} catch (PDOException $e) {
    die("Error al cargar usuarios: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Dueño</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../CSS/style.css"> 

    <style>
        .tab-menu {
            display: flex;
            gap: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .tab-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff; /* Asumiendo que usas texto claro en tu diseño glass */
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            transition: background 0.3s;
        }
        .tab-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        .tab-btn.active {
            background: rgba(255, 255, 255, 0.4);
            font-weight: 500;
        }
        .tab-content {
            display: none;
            animation: fadeIn 0.5s;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        /* Estilos básicos para los formularios */
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 0.9em;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
            color: #fff; /* Ajusta según el color de fondo */
        }
        .btn-submit {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    
    <div class="background-image"></div>

    <div class="dashboard-wrapper">
        <div class="dashboard-grid">
            
            <div class="glass-panel panel-logo">
                <img src="../MEDIA/MecaSys.png" alt="MecaSys Logo">
            </div>

            <div class="glass-panel panel-user">
                <h2>Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?></h2>
                <p>Perfil: Dueño</p>
            </div>

            <div class="glass-panel panel-main">
                <h3>Gestión de Usuarios</h3>
                
                <div class="tab-menu">
                    <button class="tab-btn active" onclick="openTab(event, 'tab-añadir')">Añadir Usuario</button>
                    <button class="tab-btn" onclick="openTab(event, 'tab-gestionar')">Modificar / Eliminar</button>
                </div>

                <div id="tab-añadir" class="tab-content" style="display: block;">
                    <div class="form-group">
                            <label>Seleccionar Usuario a modificar o eliminar:</label>
                            <select name="id_usuario_target" required>
                                <option value="" disabled selected>Selecciona un usuario...</option>
                                <?php foreach ($listaUsuarios as $user): ?>
                                    <option value="<?php echo htmlspecialchars($user['id_usuario']); ?>">
                                        <?php echo htmlspecialchars($user['nombre']) . ' (' . htmlspecialchars($user['correo']) . ')'; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                </div>

            </div>

            <div class="glass-panel panel-logout" onclick="window.location='logout.php';">
                <a href="logout.php">Cerrar Sesión</a>
            </div>

        </div>
    </div>

    <script>
        function openTab(evt, tabName) {
            // Ocultar todo el contenido de las pestañas
            let tabcontent = document.getElementsByClassName("tab-content");
            for (let i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Quitar la clase "active" de todos los botones
            let tablinks = document.getElementsByClassName("tab-btn");
            for (let i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Mostrar la pestaña actual y añadir "active" al botón clickeado
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
</body>
</html>