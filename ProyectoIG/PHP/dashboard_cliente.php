<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 1) {
    header("Location: ../index.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Cliente</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../CSS/style.css"> 
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
                <p>Perfil: Cliente</p>
            </div>

            <div class="glass-panel panel-main">
                <h3>Resumen de tu Vehículo</h3>
                <p>Aquí podrás ver el estado de tu vehículo en tiempo real y consultar tus presupuestos pendientes.</p>
            </div>

            <div class="glass-panel panel-logout" onclick="window.location='logout.php';">
                <a href="logout.php">Cerrar Sesión</a>
            </div>

        </div>
    </div>

</body>
</html>