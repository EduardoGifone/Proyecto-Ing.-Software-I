function toggle() {
    var blur=document.getElementById('blurBackground');
    blur.classList.toggle('activate');
    var blur=document.getElementById('blurNav');
    blur.classList.toggle('activate');
    var blur=document.getElementById('blur');
    blur.classList.toggle('activate');
    var popup = document.getElementById('popup');
    popup.classList.toggle('activate');
}

// Pintar y despintar de amarillo los casilleros a conveniencia
var celdas = document.getElementsByClassName("celda")
console.log(celdas)

for(let i = 0; i < celdas.length; i++){
    celdas[i].dataset.numero = i;

    celdas[i].onclick = function() {
        if("pintarAmarillo" == celdas[i].classList[2]){
            this.classList.remove("pintarAmarillo");
        }
        else{
            this.classList.add("pintarAmarillo");
        }
    }
}

var btnActualizar = document.getElementById("BtnActualizar")
var celdasP = document.getElementsByClassName("celdaP")

var arrayHorariosDisp = [];
btnActualizar.onclick = function() {
    for(let i = 0; i < celdasP.length; i++){
        if("pintarAmarillo" == celdas[i].classList[2]){
            //se pinta la celdasP de amarillo
            celdasP[i].classList.add("pintarAmarillo");
            // agregar la clase de los horarios disponibles
            if(arrayHorariosDisp.indexOf(celdas[i].classList[1]) == -1){
                arrayHorariosDisp.push(celdas[i].classList[1])
            }
        } else {
            if("pintarAmarillo" == celdasP[i].classList[2]){
                celdasP[i].classList.remove("pintarAmarillo");
                // eliminar de la lista los horarios que ya no estan disponibles
                arrayHorariosDisp = arrayHorariosDisp.filter(elem => elem != celdas[i].classList[1])
            }
        } 
    }
    closeDialog();
    console.log(arrayHorariosDisp)
    //Llamar a la funcion para ['MI10-11','JU14-15'] -> [[Miercoles,10,11],[Jueves,14,15]]
    const dispoMejorFormat = dividirArrayDisponibilidades(arrayHorariosDisp);
    // Hacer la peticion ajax
    var parametros = {
        "disponibilidades": dispoMejorFormat
    };
    //Llamar al backend
    $.ajax({
        data: parametros,
        url: 'scripts/datos.php',
        type: 'POST',
        success: function(mensaje_mostrar){
                $('#mostrar').html(mensaje_mostrar);
            }
    }).done(function(res){
        console.log(res);
    })

}