const loginForm = document.querySelector(".login-form");
const registerForm = document.querySelector(".register-form");
const wrapper = document.querySelector(".wrapper");
const loginTitle = document.querySelector(".title-login");
const registerTitle = document.querySelector(".title-register");
const signUpBtn = document.querySelector("#SignUpBtn");
const signInBtn = document.querySelector("#SignInBtn");


//SE LE CAMBIA EL TAMAÑO AL FORMS DEL LOGIN

function loginFunction(){
    loginForm.style.left = "50%";
    loginForm.style.opacity = 1;
    registerForm.style.left = "150%";
    registerForm.style.opacity = 0;
    wrapper.style.height = "400px";
    loginTitle.style.top = "50%";
    loginTitle.style.opacity = 1;
    registerTitle.style.top = "50px";
    registerTitle.style.opacity = 0;
}


//AQUI SE LE CAMBIA EL TAMAÑO AL FORM DEL REGISTER

function registerFunction(){
    loginForm.style.left = "-50%";
    loginForm.style.opacity = 0;
    registerForm.style.left = "50%";
    registerForm.style.opacity = 1;
    wrapper.style.height = "630px";
    loginTitle.style.top = "-60px";
    loginTitle.style.opacity = 0;
    registerTitle.style.top = "50%";
    registerTitle.style.opacity = 1;
}


//VALIDACIONES DE LOGIN
function validateLoginForm() {
    const email = document.getElementById('log-email').value;
    const password = document.getElementById('log-pass').value;

    if (!email || !password) {
        alert('Complete todos los campos');
        return;
    }

    const formData = new FormData();
    formData.append('email', email);
    formData.append('password', password);

    fetch('./php/login_usuario.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            if (result.rol === 'Administrador') {
                window.location.href = 'admin/dashboardAdmin.php';
            } else {
                window.location.href = 'dashboard.php';
            }
        }else {
            alert('Error: ' + result.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hubo un problema al conectar con el servidor');
    });
}


// VALIDACIONES DE REGISTRO
function validateRegisterForm() {
    const user = document.getElementById('reg-user').value;
    const name = document.getElementById('reg-name').value;
    const email = document.getElementById('reg-email').value;
    const password = document.getElementById('reg-pass').value;
    const confirmPassword = document.getElementById('con-pass').value;
    const birthdate = document.getElementById('reg-birthdate').value;
    const genero = document.querySelector('input[name="reg-genero"]:checked')?.value;

    if (!user || !name || !email || !password || !confirmPassword || !birthdate || !genero) {
        alert('Complete todos los campos');
        return;
    }

    if (user.length < 5) {
        alert('El nombre de usuario debe tener al menos 5 caracteres');
        return;
    }

    const passwordRegex = /^(?=.*[A-Z]).{8,}$/;
    if (!passwordRegex.test(password)) {
        alert('La contraseña debe tener al menos 8 caracteres y una letra mayúscula');
        return;
    }

    if (!email.includes('@')) {
        alert('Ingrese un correo válido');
        return;
    }

    if (password !== confirmPassword) {
        alert('Las contraseñas no coinciden');
        return;
    }

    const formData = new FormData();
    formData.append('name', name);
    formData.append('user', user);
    formData.append('email', email);
    formData.append('password', password);
    formData.append('birthdate', birthdate);
    formData.append('genero', genero);

    console.log("Enviando datos a: php/registro.php");

    fetch('./php/registro.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            alert('registro con madre');
            console.log('registro con madre');
            window.location.href = 'perfil.php';
        } else {
            alert('Error al registrar: ' + result.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hubo un problema al conectar con el servidor');
    });
}
