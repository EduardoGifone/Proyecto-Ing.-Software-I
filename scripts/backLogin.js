// Habilitar la tecla enter para enviar formulario
var button = document.getElementById("send")
document.getElementById("user").addEventListener("keydown", function (event) {
    if (event.keyCode == 13) {
        button.click();
    }
})
document.getElementById("pass").addEventListener("keydown", function (event) {
    if (event.keyCode == 13) {
        button.click();
    }
})
// Crear notificacion
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

//Funcion para validar formulario
function validar(){
    //Obtener valores
    var usuario = document.getElementById("user").value
    var password = document.getElementById("pass").value
    var parametros = {
        "usuario": usuario,
        "password": password,
    };
    //Llamar al backend
    $.ajax({
        data: parametros,
        url: 'backLogin.php',
        type: 'POST',
        success: function(mensaje_mostrar){
                // window.location.href("main.php");
                if(mensaje_mostrar == "menuAlumno"){
                    window.location.replace("principal_alumno.php")
                }
                else if (mensaje_mostrar == "menuTutor"){
                    window.location.replace("principal_tutor.php")
                }
                else{
                    Toast.fire({
                        icon: 'error',
                        title: 'Error',
                        text: mensaje_mostrar,
                        color: '#f0716a',
                        backdrop: true                        
                    })
                }
        }
    });
}  