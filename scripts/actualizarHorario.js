// COMPONENTE : Seleccionar casillas de disponibilidad

// Pintar y despintar de amarillo los casilleros a conveniencia
// cada vez que el tutor de click en la casilla que requiera
var celdas = document.getElementsByClassName("celda")
console.log(celdas)

for(let i = 0; i < celdas.length; i++){
    celdas[i].dataset.numero = i;

    celdas[i].onclick = function() {
        //se cambio de celdas[i] a this, ya que habia un error
        console.log('Un clicksito '+this.classList+' i:'+i)
        if("pintarAmarillo" == this.classList[2]){
            console.log('elimnar clicksito')
            this.classList.remove("pintarAmarillo");
        }
        else{
            this.classList.add("pintarAmarillo");
        }
    }
}

//Cuando el tutor dé click en actualizar para actualizar toda su disponibilidad
//se enviara esa informacion mediante AJAX a PHP y luego a la BD

var btnActualizar = document.getElementById("BtnActualizar")
var celdasP = document.getElementsByClassName("celdaP")

var arrayHorariosDisp = [];
btnActualizar.onclick = function() {
    for(let i = 0; i < celdasP.length; i++){
        console.log(celdas[i].classList)
        if("pintarAmarillo" == celdas[i].classList[2]){
            console.log("pintando amarillo hor principal")
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
    //closeDialogAll('dialog','blur','blurBackground');
    hideModalDialog('dialog');

    //console.log(arrayHorariosDisp)
    //Llamar a la funcion para ['MI10-11','JU14-15'] -> [[Miercoles,10,11],[Jueves,14,15]]
    const dispoMejorFormat = dividirArrayDisponibilidades(arrayHorariosDisp);

    
    //COMPONENTE : Enviar datos de disponibilidad para actualizar BD

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
        //console.log(res);
    })
}