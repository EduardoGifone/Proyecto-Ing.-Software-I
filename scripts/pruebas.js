var arrayDisp = ['LU10-11','MI14-15','JU18-19']

// Mapas (diccionarios)
let Dias = new Map();
Dias.set("LU","Lunes");
Dias.set("MA","Martes");
Dias.set("MI","Miercoles");
Dias.set("JU","Jueves");
Dias.set("VI","Viernes");
Dias.set("SA","Sabado");
Dias.set("DO","Domingo");


function dividirArrayDisponibilidades(arrayDisp, Dias) {
    var disponibilidades = [];
    for(let i = 0; i < arrayDisp.length; i++){
        var disponibilidad = [];
        var elem = arrayDisp[i];
        //dividir la disponibilidad i en dia y horas
        var dia = elem.slice(0,2);
        var horas = elem.slice(2);
        //agregar dia a disponibilidad
        disponibilidad.push(Dias.get(dia));

        //dividir las horas
        var Hrs = horas.split("-")
        //agregar las horas
        disponibilidad.push(Hrs[0]);
        disponibilidad.push(Hrs[1]);

        // agregar el datos del i horario disponible
        disponibilidades.push(disponibilidad);
    }
    return(disponibilidades)
}

let A = dividirArrayDisponibilidades(arrayDisp, Dias);
console.log(A);