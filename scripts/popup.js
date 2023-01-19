
// Para hacer aparecer el contenedor que queremos y difuminar el resto
const ShowDialogAll = (idContenedorAMostrar, Blur, BlurBackground) => {
    console.log('---------------------')
    console.log(idContenedorAMostrar)
    var blur = document.getElementById(Blur);
    blur.classList.toggle('activate')
    var blur=document.getElementById(BlurBackground);
    blur.classList.toggle('activate');

    //para que asi no se agregue show al instante
    setTimeout(() => {
        document.getElementById(idContenedorAMostrar).classList.add('show')
    }, 1);

    const scrollY = document.documentElement.style.getPropertyValue('--scroll-y');
    const body = document.body;
    body.style.position = 'fixed';
    console.log(body.style.top)
    body.style.top = `-${scrollY}`;
    console.log(body.style.top)
}

//Para cerrar el contenedor y regresar a la pantalla anterior
const closeDialogAll = (idContenedorAMostrar, Blur, BlurBackground) => {
    var blur = document.getElementById(Blur);
    console.log('se esta aplicando closeDialog')
    blur.classList.toggle('activate');
    var blur=document.getElementById(BlurBackground);
    blur.classList.toggle('activate');

    const body = document.body;
    const scrollY = body.style.top;
    body.style.position = '';
    body.style.top = '';
    window.scrollTo(0, parseInt(scrollY || '0') * -1);
    document.getElementById(idContenedorAMostrar).classList.remove('show');
    console.log(`-${scrollY}`)
}

//Para al hacer click en el icono de campanita se habran o cierren las notif
const efectoBlurANotificacion = (contenedor,Blur, BlurBackground) => {
    var notif = document.getElementById(contenedor)
    if (notif.classList[1] == 'show'){
        closeDialogAll(contenedor,Blur,BlurBackground)
    }
    else
    {
        ShowDialogAll(contenedor,Blur,BlurBackground)
    }
}

// Para cerrar al dar en un campo que no sea el contenedor dado
window.addEventListener('click', function(e){
    var notif = document.getElementById('dialogNotiAlumno')
    if (notif.classList[1] == 'show'){
        if (notif.contains(e.target)){
        } else{
            closeDialogAll('dialogNotiAlumno','blurA','blurBackgroundA')
        }
    }   
})


window.addEventListener('click', function(e){
    var notif = document.getElementById('dialogNoti')
    if (notif.classList[1] == 'show'){
        if (notif.contains(e.target)){
        } else{
            closeDialogAll('dialogNoti','blur','blurBackground')
        }
    }   
})


window.addEventListener('click', function(e){
    var notif = document.getElementById('dialogInformacionCita')
    if (notif.classList[1] == 'show'){
        if (notif.contains(e.target)){
        } else{
            closeDialogAll('dialogInformacionCita', 'blur', 'blurBackground') 
        }
    }   
})

// Permitir que la pantalla se reajuste como se deba
window.addEventListener('scroll', () => {
    document.documentElement.style.setProperty('--scroll-y', `${window.scrollY}px`);
});