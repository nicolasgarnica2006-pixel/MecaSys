<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 3) {
    header("Location: ../index.php"); 
    exit();
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
                    <form action="procesar_usuario.php" method="POST">
                        <input type="hidden" name="accion" value="crear">
                        
                        <div class="form-group">
                            <label>Nombre Completo:</label>
                            <input type="text" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label>Correo Electrónico:</label>
                            <input type="email" name="correo" required>
                        </div>
                        <div class="form-group">
                            <label>Contraseña:</label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label>Rol del Usuario:</label>
                            <select name="id_rol" required>
                                <option value="">Seleccione un rol...</option>
                                <option value="1">Empleado</option>
                                <option value="2">Gerente</option>
                                <option value="3">Dueño</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-submit">Registrar Usuario</button>
                    </form>
                </div>

                <div id="tab-gestionar" class="tab-content">
                    <p><i>Aquí puedes cargar una tabla dinámica o un buscador para seleccionar al usuario que deseas modificar.</i></p>
                    
                    <form action="procesar_usuario.php" method="POST">
                        <input type="hidden" name="accion" value="modificar">
                        
                        <div class="form-group">
                            <label>Seleccionar Usuario a modificar:</label>
                            <select name="id_usuario_target" required>
                                <option value="1">Ejemplo: Juan Pérez</option>
                                </select>
                        </div>
                        <div class="form-group">
                            <label>Nuevo Nombre (dejar en blanco para no cambiar):</label>
                            <input type="text" name="nuevo_nombre">
                        </div>
                        <div class="form-group">
                            <label>Nuevo Correo:</label>
                            <input type="email" name="nuevo_correo">
                        </div>
                        <div class="form-group">
                            <label>Nueva Contraseña:</label>
                            <input type="password" name="nueva_password">
                        </div>
                        <div class="form-group">
                            <label>Cambiar Rol:</label>
                            <select name="nuevo_rol">
                                <option value="">Mantener rol actual</option>
                                <option value="1">Empleado</option>
                                <option value="2">Gerente</option>
                                <option value="3">Dueño</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-submit" style="background: #2196F3;">Actualizar Datos</button>
                        
                        <button type="submit" name="accion" value="eliminar" class="btn-submit" style="background: #f44336; margin-left: 10px;" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar Usuario</button>
                    </form>
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