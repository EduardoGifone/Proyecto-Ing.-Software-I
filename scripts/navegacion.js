// Permite que al elegir alguna pagina de navegacion, esta quede marcada de amarillo
function elegirPagina(tipoAlternativa){
    var alternativas = document.getElementsByClassName('alternativa')
    for(alternativa of alternativas){
        alternativa.classList.remove("abierto");
    }
    document.getElementById(tipoAlternativa).classList.add('abierto')
}