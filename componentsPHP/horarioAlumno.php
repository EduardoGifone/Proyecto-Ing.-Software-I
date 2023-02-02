<?php

//Consultar si hay citas pendientes y confirmadas
//echo "<p>$alumno_codigo</p>";
//COMPONENTE : obtener citas confirmadas o pendientes de BD del alumno usuario
$consultaCitaPend = "SELECT * FROM cita WHERE codigoAlumno = '$alumno_codigo' and (estado = 'pendiente' or estado = 'confirmado')";
$resultadoConsultaCita = mysqli_query($conexion, $consultaCitaPend);
$filasCitasDisponibles = mysqli_num_rows($resultadoConsultaCita);

$fechaConsulta = '';
$horaInicio = '';
$horaFin = '';
$estado = '';
if($filasCitasDisponibles){
    //echo "<p>$filasCitasDisponibles</p>";
    while ($citaAlumno = mysqli_fetch_assoc($resultadoConsultaCita)) {
        $fechaConsulta = $citaAlumno["fecha"];
        $horaInicio = $citaAlumno["horaInicio"];  
        $horaFin = $citaAlumno["horaFin"];  
        $estado = $citaAlumno["estado"];
        //echo "<p>$fechaConsulta</p>";
    }
}

//para almacenar los codigos de las disponibilidades
$disponibilidades = [];
$Dias = array(
    "Lunes" => "LU",
    "Martes" =>"MA",
    "Miercoles" => "MI",
    "Jueves" => "JU",
    "Viernes" => "VI",
    "Sabado" => "SA",
    "Domingo" => "DO"
);
//Iterar dentro de $resultadoConsulta y obtener el codigo de disponibilidades
//Para mostrar al alumno las disponibilidades de su tutor
while($datosDisp = mysqli_fetch_assoc($resultadoConsulta)){
    
    //Obtener datos de los arreglos
    $dia = $datosDisp["dia"];
    $Hini = $datosDisp["horaInicio"];
    $Hfin = $datosDisp["horaFin"];
    $CodigoDisp = $Dias[$dia].$Hini.'-'.$Hfin;
    //agregar disponibilidades al arreglo
    array_push($disponibilidades,$CodigoDisp);
}

?>
 
<table border="1" class="tabla__horario">
    <tr>
        <th class="encabezado">HORAS</th>
        <th class="encabezado">LUNES</th>
        <th class="encabezado">MARTES</th>
        <th class="encabezado">MIERCOLES</th>
        <th class="encabezado">JUEVES</th>
        <th class="encabezado">VIERNES</th>
        <th class="encabezado">SABADO</th>
        <th class="encabezado">DOMINGO</th>
    </tr>
    <tr>
        <th>07:00 - 09:00</th>
        <td>
            <a href="#" type='button' class="celdaP" id="LU7-8"></a>
            <a href="#" type='button' class="celdaP" id="LU8-9"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="MA7-8"></a>
            <a href="#" type='button' class="celdaP" id="MA8-9"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="MI7-8"></a>
            <a href="#" type='button' class="celdaP" id="MI8-9"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="JU7-8"></a>
            <a href="#" type='button' class="celdaP" id="JU8-9"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="VI7-8"></a>
            <a href="#" type='button' class="celdaP" id="VI8-9"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="SA7-8"></a>
            <a href="#" type='button' class="celdaP" id="SA8-9"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="DO7-8"></a>
            <a href="#" type='button' class="celdaP" id="DO8-9"></a>
        </td>
    </tr>
    <tr>
        <th>09:00 - 11:00</th>
        <td>
            <a href="#" type='button' class="celdaP" id="LU9-10"></a>
            <a href="#" type='button' class="celdaP" id="LU10-11"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="MA9-10"></a>
            <a href="#" type='button' class="celdaP" id="MA10-11"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="MI9-10"></a>
            <a href="#" type='button' class="celdaP" id="MI10-11"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="JU9-10"></a>
            <a href="#" type='button' class="celdaP" id="JU10-11"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="VI9-10"></a>
            <a href="#" type='button' class="celdaP" id="VI10-11"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="SA9-10"></a>
            <a href="#" type='button' class="celdaP" id="SA10-11"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="DO9-10"></a>
            <a href="#" type='button' class="celdaP" id="DO10-11"></a>
        </td>
    </tr>
    <tr>
        <th>11:00 - 13:00</th>
        <td>
            <a href="#" type='button' class="celdaP" id="LU11-12"></a>
            <a href="#" type='button' class="celdaP" id="LU12-13"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="MA11-12"></a>
            <a href="#" type='button' class="celdaP" id="MA12-13"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="MI11-12"></a>
            <a href="#" type='button' class="celdaP" id="MI12-13"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="JU11-12"></a>
            <a href="#" type='button' class="celdaP" id="JU12-13"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="VI11-12"></a>
            <a href="#" type='button' class="celdaP" id="VI12-13"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="SA11-12"></a>
            <a href="#" type='button' class="celdaP" id="SA12-13"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="DO11-12"></a>
            <a href="#" type='button' class="celdaP" id="DO12-13"></a>
        </td>
    </tr>
    <tr>
        <th>13:00 - 15:00</th>
        <td>
            <a href="#" type='button' class="celdaP" id="LU13-14"></a>
            <a href="#" type='button' class="celdaP" id="LU14-15"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="MA13-14"></a>
            <a href="#" type='button' class="celdaP" id="MA14-15"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="MI13-14"></a>
            <a href="#" type='button' class="celdaP" id="MI14-15"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="JU13-14"></a>
            <a href="#" type='button' class="celdaP" id="JU14-15"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="VI13-14"></a>
            <a href="#" type='button' class="celdaP" id="VI14-15"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="SA13-14"></a>
            <a href="#" type='button' class="celdaP" id="SA14-15"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="DO13-14"></a>
            <a href="#" type='button' class="celdaP" id="DO14-15"></a>
        </td>
    </tr>
    <tr>
        <th>15:00 - 17:00</th>
        <td>
            <a href="#" type='button' class="celdaP" id="LU15-16"></a>
            <a href="#" type='button' class="celdaP" id="LU16-17"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="MA15-16"></a>
            <a href="#" type='button' class="celdaP" id="MA16-17"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="MI15-16"></a>
            <a href="#" type='button' class="celdaP" id="MI16-17"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="JU15-16"></a>
            <a href="#" type='button' class="celdaP" id="JU16-17"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="VI15-16"></a>
            <a href="#" type='button' class="celdaP" id="VI16-17"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="SA15-16"></a>
            <a href="#" type='button' class="celdaP" id="SA16-17"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="DO15-16"></a>
            <a href="#" type='button' class="celdaP" id="DO16-17"></a>
        </td>
    </tr>
    <tr>
        <th>17:00 - 19:00</th>
        <td>
            <a href="#" type='button' class="celdaP" id="LU17-18"></a>
            <a href="#" type='button' class="celdaP" id="LU18-19"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="MA17-18"></a>
            <a href="#" type='button' class="celdaP" id="MA18-19"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="MI17-18"></a>
            <a href="#" type='button' class="celdaP" id="MI18-19"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="JU17-18"></a>
            <a href="#" type='button' class="celdaP" id="JU18-19"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="VI17-18"></a>
            <a href="#" type='button' class="celdaP" id="VI18-19"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="SA17-18"></a>
            <a href="#" type='button' class="celdaP" id="SA18-19"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="DO17-18"></a>
            <a href="#" type='button' class="celdaP" id="DO18-19"></a>
        </td>
    </tr>
    <tr>
        <th>19:00 - 21:00</th>
        <td>
            <a href="#" type='button' class="celdaP" id="LU19-20"></a>
            <a href="#" type='button' class="celdaP" id="LU20-21"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="MA19-20"></a>
            <a href="#" type='button' class="celdaP" id="MA20-21"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="MI19-20"></a>
            <a href="#" type='button' class="celdaP" id="MI20-21"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="JU19-20"></a>
            <a href="#" type='button' class="celdaP" id="JU20-21"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="VI19-20"></a>
            <a href="#" type='button' class="celdaP" id="VI20-21"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="SA19-20"></a>
            <a href="#" type='button' class="celdaP" id="SA20-21"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="DO19-20"></a>
            <a href="#" type='button' class="celdaP" id="DO20-21"></a>
        </td>
    </tr>
    <tr>
        <th>21:00 - 23:00</th>
        <td>
            <a href="#" type='button' class="celdaP" id="LU21-22"></a>
            <a href="#" type='button' class="celdaP" id="LU22-23"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="MA21-22"></a>
            <a href="#" type='button' class="celdaP" id="MA22-23"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="MI21-22"></a>
            <a href="#" type='button' class="celdaP" id="MI22-23"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="JU21-22"></a>
            <a href="#" type='button' class="celdaP" id="JU22-23"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="VI21-22"></a>
            <a href="#" type='button' class="celdaP" id="VI22-23"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="SA21-22"></a>
            <a href="#" type='button' class="celdaP" id="SA22-23"></a>
        </td>
        <td>
            <a href="#" type='button' class="celdaP" id="DO21-22"></a>
            <a href="#" type='button' class="celdaP" id="DO22-23"></a>
        </td>
    </tr>
</table>


<!-- PINTAR LAS CASILLAS DE AMARILLO, AZUL O VERDE SI CORRESPONDE -->
<script src="./scripts/dividirDisponibilidades.js"></script>  
<script>
    //Obtener las citas pendientes del alumno
    var citasDisponibles = '<?php echo $filasCitasDisponibles;?>'
    console.log('citas para este: '+citasDisponibles)
    //Restringir si hay alguna solicitud de cita ya pendiente 
    if(citasDisponibles > 0){
        //COMPONENTE : Pintar casilla pendiente o aceptada
        console.log('tamos aqui ya que citasDisponibles > 0')
        var estado = '<?php echo $estado;?>';
        //Obtener variables de PHP para generar el id de la casilla correspondiente
        var dia = deFechaANombreDia('<?php echo $fechaConsulta;?>');
        var horaInicio = '<?php echo $horaInicio;?>';
        var horaFin = '<?php echo $horaFin;?>';
        //Obtener ID en base a su dia, hora de inicio y hora de fin
        let codigo = ObtenerCodigoDisponibilidad(dia,horaInicio,horaFin)
        console.log('estado'+estado)
        // RUTINA 5 : Actualizar horario del alumno despues de confirmar una cita
        if (estado == 'CONFIRMADO' | estado == 'Confirmado' ){
            console.log('Tenemos una cita confirmada')
            //Colorear el cuadro respectivo
            casilla = document.getElementById(codigo)
            casilla.classList.add("pintarAzul")
        }
        if (estado == 'PENDIENTE' | estado == 'Pendiente'){
            console.log('Tenemos una cita pendiente')
            //Colorear el cuadro respectivo
            casilla = document.getElementById(codigo)
            casilla.classList.add("pintarVerde")
        }
    }
    else{
        //COMPONENTE : Pintar casillas de disponibilidades
        var arregloEnJson = '<?php echo json_encode($disponibilidades);?>';
        var ACodDisp = JSON.parse(arregloEnJson);
        console.log('Las casillas disponibles')
        console.log(ACodDisp)
        ACodNoDisp = obtenerCasillasNoDisponiblesAMostrar(ACodDisp);
        
        for(let i = 0; i < ACodDisp.length; i++){
            var celda = document.getElementById(ACodDisp[i]);
            celda.classList.add("pintarAmarillo");
        }
        //Bloquear las casillas que ya no estas disponibles para solicitar cita
        for(let i = 0; i < ACodNoDisp.length; i++){
            var celda = document.getElementById(ACodNoDisp[i]);
            celda.classList.remove("pintarAmarillo");
            celda.classList.add("pintarAmarilloClaro");
        }
    }

    //Obtener las casillas que ya no estan disponibles para solicitar cita
    //COMPONENTE : Obtener casillas no disponibles a solicitar
    function obtenerCasillasNoDisponiblesAMostrar(codigoCasillas) {
        var inicialesDiasDisp = [];
        var nroDiaHoy = ObtenerNumeroDiaHoy()
        //D7 L1 M2 Mi3 J4 V5 S6
        nroDiaHoy = nroDiaHoy == 0? 7 : nroDiaHoy;
        // Mapas (diccionarios)
        let nroDias = new Map();
        nroDias.set("LU",1);
        nroDias.set("MA",2);
        nroDias.set("MI",3);
        nroDias.set("JU",4);
        nroDias.set("VI",5);
        nroDias.set("SA",6);
        nroDias.set("DO",7);
        //Colocar cada casilla del dia que ya haya pasado
        for(let i = 0; i < codigoCasillas.length; i++){
            var codDia = codigoCasillas[i].slice(0,2)
            if(nroDias.get(codDia) <= nroDiaHoy){
                inicialesDiasDisp.push(codigoCasillas[i]);
            }
        }
        console.log('Inicials: ',inicialesDiasDisp);
        return inicialesDiasDisp
    }

    // Domingo -> 1, Lunes -> 2, ...
    function ObtenerNumeroDiaHoy(){
        // crea un nuevo objeto `Date`
        var today = new Date();
        // obtener la fecha de hoy en formato `MM/DD/YYYY`
        var now = today.toLocaleDateString('en-US');

        var Xmas95 = new Date(now);
        //var Xmas95 = new Date('January 16, 2023 23:15:30');
        var weekday = Xmas95.getDay();
        console.log('hoy es:',weekday);

        return weekday
    }
</script>

<!-- MOSTRAR LA INTERFAZ PARA SOLICITAR CITA CON LOS VALORES ADECUADOS -->
<script>
    // Generar la interfaz para solicitar una cita
    // COMPONENTE : Actualizar datos del casillero seleccionado
    var celdas = document.getElementsByClassName("celdaP")
    
    for(let i = 0; i < celdas.length; i++){
        celdas[i].dataset.numero = i;

        celdas[i].onclick = function() {
            if(celdas[i].classList[2] != "pintarVerde" && celdas[i].classList[1] == "pintarAmarillo")
            {
                //ShowDialogAll('dialog', 'blurA','blurBackgroundA')
                showModalDialog('dialog')
                this.classList.add("pintarVerde");
            }
            
            //obtener informacion de la interfaz y colocarla
            let datosHorario = obtenerDatosCasilleroSeleccionado();
            console.log('--------')
            console.log(datosHorario)
            let hIni = datosHorario[1];
            let hFin = datosHorario[2];
            let day = datosHorario[0];

            let Hora = "Hora : " + hIni + ":00 - " + hFin + ":00";
            let Dia = "Dia : " + day;
            document.getElementById("razon-Dia").innerHTML = Hora
            document.getElementById("razon-Hora").innerHTML = Dia

        }
    }

    // COMPONENTE : Obtener datos del casillero seleccionado
    function obtenerDatosCasilleroSeleccionado() {

        //Obtener las horas y dia
        let datosHorario;
        var casillasVerdes = document.getElementsByClassName("pintarVerde") 
        if(casillasVerdes.length > 0){
            //obtener informacion del casillero : LU10-11
            hora = casillasVerdes[0].id;
            //Llamar a la funcion LU10-11 -> ['Lunes','10','11']
            datosHorario = dividirInfoDisponibilidad(hora);
        }
        console.log(datosHorario);
        return datosHorario;
    }

    //Obtener valores de las casillas para preescribirlos en la solicitud
    //Obtener nombre y apellido
    var name = '<?php echo $alumno_nombre;?>';
    var apellido = '<?php echo $alumno_apellido;?>';
    document.getElementById("nombres").value = name;
    document.getElementById("apellidos").value = apellido;
</script>