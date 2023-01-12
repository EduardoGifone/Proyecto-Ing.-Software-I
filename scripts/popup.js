
window.addEventListener('click', function(e){
    var notif = document.getElementById('dialogInformacionCita')
    if (notif.classList[1] == 'show'){
        if (notif.contains(e.target)){
        } else{
            closeDialogAll('dialogInformacionCita', 'blur', 'blurBackground') 
        }
    }   /*
    const scrollY = document.documentElement.style.getPropertyValue('--scroll-y');
    const body = document.body;
    body.style.top = `-${scrollY}`;
    console.log('click: '+body.style.top);

    body.style.top = '';
    window.scrollTo(0, parseInt('-102px') * -1);*/
})

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

const efectoBlurANotificacion = () => {
    var notif = document.getElementById('dialogNoti')
    if (notif.classList[1] == 'show'){
        closeDialogAll('dialogNoti','blur','blurBackground')
    }
    else
    {
        ShowDialogAll('dialogNoti','blur','blurBackground')
    }
}

window.addEventListener('click', function(e){
    var notif = document.getElementById('dialogNoti')
    if (notif.classList[1] == 'show'){
        if (notif.contains(e.target)){
        } else{
            closeDialogAll('dialogNoti','blur','blurBackground')
        }
    }   
})

window.addEventListener('scroll', () => {
    document.documentElement.style.setProperty('--scroll-y', `${window.scrollY}px`);
});