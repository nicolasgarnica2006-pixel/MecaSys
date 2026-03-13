<!DOCTYPE html>
<html lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Taller</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="CSS/style.css">
    
    <style>
        /* Alerta de errores */
        .alerta-error {
            background-color: #ffebee;
            color: #c62828;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 0.9em;
            border: 1px solid #ffcdd2;
        }

        .login-container {
            display: flex;
            flex-direction: row; /* Coloca los elementos uno al lado del otro */
            align-items: center;
            justify-content: space-between;
            max-width: 850px !important; /* Hacemos el contenedor más ancho */
            width: 90%;
            gap: 40px; /* Separación entre el logo y el formulario */
        }

        /* Lado izquierdo (Logo) */
        .login-brand {
            flex: 1; /* Ocupa la mitad del espacio disponible */
            display: flex;
            justify-content: center;
        }

        /* Lado derecho (Formulario) */
        .login-form-area {
            flex: 1; /* Ocupa la otra mitad */
            width: 100%;
        }

        /* * MEDIA QUERY:
         */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column; 
                gap: 20px;
                padding: 30px 20px;
            }
            .login-brand img {
                max-width: 250px;
            }
        }
    </style>
</head>
<body>

    <div class="background-image"></div>

    <div class="login-container">
        
        <div class="login-brand">
            <img src="/MEDIA/MecaSys.png" alt="LOGO" style="max-width: 100%; height: auto; filter: drop-shadow(0 0 10px rgba(0, 243, 255, 0.2));"> 
        </div>

        <div class="login-form-area">
            <h2>Bienvenido</h2>

            <?php if (isset($_GET['error'])): ?>
                <div class="alerta-error">
                    <?php 
                        if ($_GET['error'] == 'credenciales') echo "Correo o contraseña incorrectos.";
                        elseif ($_GET['error'] == 'rol') echo "El rol seleccionado no corresponde.";
                        elseif ($_GET['error'] == 'vacios') echo "Por favor, completa todos los campos.";
                    ?>
                </div>
            <?php endif; ?>

            <form action="PHP/login.php" method="POST">

                <div class="input-group">
                    <label for="id_rol">Acceder como</label>
                    <select id="id_rol" name="id_rol" required>
                        <option value="" disabled selected>Selecciona tu rol...</option>
                        <option value="1">Cliente</option>
                        <option value="2">Mecánico</option>
                        <option value="3">Dueño del Taller</option>
                    </select>
                </div>

                <div class="input-group">
                    <label for="correo">Correo Electrónico</label>
                    <input type="email" id="correo" name="correo" placeholder="ejemplo@correo.com" required>
                </div>

                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">
                </div>

                <button type="submit" class="btn-submit">Ingresar</button>

            </form>
        </div>

    </div>

</body>
</html>