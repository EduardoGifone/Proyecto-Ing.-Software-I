var arrayDisp = ['LU10-11','MI14-15','JU18-19']

function dividirArrayDisponibilidades(arrayDisp) {

    var disponibilidades = [];
    for(let i = 0; i < arrayDisp.length; i++){

        var disponibilidad = dividirInfoDisponibilidad(arrayDisp[i])
        // agregar el datos del i horario disponible
        disponibilidades.push(disponibilidad);
    }
    return(disponibilidades)
}

//disponibilidadC del codigo
const dividirInfoDisponibilidad = (dispCodigo) => {
    // Mapas (diccionarios)
    let Dias = new Map();
    Dias.set("LU","Lunes");
    Dias.set("MA","Martes");
    Dias.set("MI","Miercoles");
    Dias.set("JU","Jueves");
    Dias.set("VI","Viernes");
    Dias.set("SA","Sabado");
    Dias.set("DO","Domingo");

    var disponibilidad = [];
    var elem = dispCodigo;
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

    return disponibilidad;

}

//let A = dividirArrayDisponibilidades(arrayDisp, Dias);
//console.log(A);