document.addEventListener('DOMContentLoaded', () => {
    Swal.fire({
        title: '!Bienvenido!',
        text: 'Si desea ingresar por primera vez agrege los datos solicitados y pulse el boton "Registrarse", inmediatamente vuelva a agregar los datos y pulse "Iniciar Sesion", Si solo desea ingresar agrege los datos y seleccione "Iniciar Sesion"',
        icon: 'success',
    });
});

function bloquearNumeros(event) {
    let charCode = event.charCode ? event.charCode : event.keyCode;
    if (charCode >= 48 && charCode <= 57) {
        event.preventDefault();
    }
}