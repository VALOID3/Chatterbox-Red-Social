<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/background.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
    <link rel="icon" type="image/png" href="images/CHATTERBOX.png">

</head>

<body>

    <iframe src="navbar.php" class="navbar-frame"></iframe>
    <link rel="stylesheet" href="css/navbar.css">

    <div class="wrapper">
        <div class="form-header">
            <div class="titles">
                <div class="title-login">Login</div>
                <div class="title-register">Registro</div>
            </div>

        </div>
        <!-- LOGIN FORM -->
        <form action="#" class="login-form" autocomplete="off">
            <div class="input-box">
                <input type="text" class="input-field" id="log-email" required>
                <label for="log-email" class="label">Email</label>
                <i class='bx bx-envelope icon'></i>
            </div>
            <div class="input-box">
                <input type="password" class="input-field" id="log-pass" required>
                <label for="log-pass" class="label">Contraseña</label>
                <i class='bx bx-lock-alt icon'></i>
            </div>
            <div class="input-box">
                <button class="btn-submit" id="SignInBtn" type="button" onclick="validateLoginForm()">Ingresar <i
                        class='bx bx-log-in'></i></button>
            </div>
            <div class="switch-form">
                <span>¿Todavia no tiene una cuenta? <a href="#" onclick="registerFunction()">Registrese</a></span>
            </div>
        </form>

        <!-- REGISTER FORM -->
        <form action="#" class="register-form" autocomplete="off">



            <div class="input-box">
                <input type="text" class="input-field" id="reg-user" required>
                <label for="reg-user" class="label">Usuario</label>
                <i class='bx bx-user icon'></i>
            </div>

            <div class="input-box">
                <input type="text" class="input-field" id="reg-name" required>
                <label for="reg-name" class="label">Nombre</label>
                <i class='bx bx-user icon'></i>
            </div>

            <div class="input-box">
                <input type="text" class="input-field" id="reg-email" required>
                <label for="reg-email" class="label">Email</label>
                <i class='bx bx-envelope icon'></i>
            </div>

            <div class="input-box">
                <input type="password" class="input-field" id="reg-pass" required>
                <label for="reg-pass" class="label">Contraseña</label>
                <i class='bx bx-lock-alt icon'></i>
            </div>

            <div class="input-box">
                <input type="password" class="input-field" id="con-pass" required>
                <label for="con-pass" class="label">Confirmar contraseña</label>
                <i class='bx bx-lock-alt icon'></i>
            </div>

            <div class="input-box">
                <input type="date" class="input-field" id="reg-birthdate" required>
                <label for="reg-birthdate" class="label"></label>
                <i class='bx bx-calendar icon'></i>
            </div>





            <!-- SELECCIONAR GENERO -->


            <link rel="stylesheet" href="css/genero.css">

            <div class="container-navbuttons">

                <!-- From Uiverse.io by Pradeepsaranbishnoi -->
                <div class="mydict">
                    <div>
                        <label>
                            <input type="radio" name="reg-genero" value="Masculino">
                            <span>Hombre</span>
                        </label>
                        <label>
                            <input type="radio" name="reg-genero" value="Femenino">
                            <span>Mujer</span>
                        </label>

                    </div>
                </div>

            </div>

            <div class="input-box">
                <button class="btn-submit" id="SignUpBtn" type="button" onclick="validateRegisterForm()">Registrarse <i
                        class='bx bx-user-plus'></i></button>
            </div>
            <div class="switch-form">
                <span>¿Ya tiene cuenta? <a href="#" onclick="loginFunction()">Ingresar</a></span>
            </div>

            <br>

        </form>
    </div>



    <script src="js/login.js"></script>

    <!-- FOOTER -->
    <footer class="footer">
        <p>&copy; 2024 CHATTERBOX | Todos los derechos reservados.</p>
    </footer>
    <link rel="stylesheet" href="css/footer.css">

</body>

</html>