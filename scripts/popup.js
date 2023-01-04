window.addEventListener('click', function(e){
    var notif = document.getElementById('dialogInformacionCita')
    if (notif.classList[1] == 'show'){
        if (notif.contains(e.target)){
        } else{
            closeDialogInformacion()
            
        }
    }   /*
    const scrollY = document.documentElement.style.getPropertyValue('--scroll-y');
    const body = document.body;
    body.style.top = `-${scrollY}`;
    console.log('click: '+body.style.top);

    body.style.top = '';
    window.scrollTo(0, parseInt('-102px') * -1);*/
})

const showDialogInformacion = () => {
    console.log('showDialogInformacion')
    var blur = document.getElementById('blur');
    blur.classList.toggle('activate')
    var blur=document.getElementById('blurBackground');
    blur.classList.toggle('activate');

    //para que asi no se agregue show al instante
    setTimeout(() => {
        document.getElementById('dialogInformacionCita').classList.add('show')
    }, 1);

    const scrollY = document.documentElement.style.getPropertyValue('--scroll-y');
    const body = document.body;
    body.style.position = 'fixed';
    body.style.top = `-${scrollY}`;
    console.log('open: '+body.style.top);
};

const closeDialogInformacion = () => {
    var blur = document.getElementById('blur');
    blur.classList.toggle('activate')
    var blur=document.getElementById('blurBackground');
    blur.classList.toggle('activate');

    const body = document.body;
    const scrollY = body.style.top;
    body.style.position = '';
    body.style.top = '';
    window.scrollTo(0, parseInt(scrollY || '0') * -1);
    document.getElementById('dialogInformacionCita').classList.remove('show');
    console.log(`-${scrollY}`)
}


const efectoBlurANotificacion = () => {
    var notif = document.getElementById('dialogNoti')
    if (notif.classList[1] == 'show'){
        closeDialogNoti()
    }
    else
    {
        showDialogNoti()
    }
}

window.addEventListener('click', function(e){
    var notif = document.getElementById('dialogNoti')
    if (notif.classList[1] == 'show'){
        if (notif.contains(e.target)){
        } else{
            closeDialogNoti()
        }
    }   
})

const showDialogNoti = () => {
    var blur = document.getElementById('blur');
    blur.classList.toggle('activate')
    var blur=document.getElementById('blurBackground');
    blur.classList.toggle('activate');
    //para que asi no se agregue show al instante
    setTimeout(() => {
        document.getElementById('dialogNoti').classList.add('show')
    }, 1);
    
    const scrollY = document.documentElement.style.getPropertyValue('--scroll-y');
    const body = document.body;
    body.style.position = 'fixed';
    body.style.top = `-${scrollY}`;
}

const closeDialogNoti = () => {
    var blur = document.getElementById('blur');
    blur.classList.toggle('activate')
    var blur=document.getElementById('blurBackground');
    blur.classList.toggle('activate');

    const body = document.body;
    const scrollY = body.style.top;
    body.style.position = '';
    body.style.top = '';
    window.scrollTo(0, parseInt(scrollY || '0') * -1);
    document.getElementById('dialogNoti').classList.remove('show');
    console.log(`-${scrollY}`)
}

// ---------------------------------------------------------------
const showDialog = () => {

    console.log('A desde popup showDialog')
    var blur = document.getElementById('blur');
    blur.classList.toggle('activate')
    var blur=document.getElementById('blurBackground');
    blur.classList.toggle('activate');

    document.getElementById('dialog').classList.add('show')
    const scrollY = document.documentElement.style.getPropertyValue('--scroll-y');
    const body = document.body;
    body.style.position = 'fixed';
    body.style.top = `-${scrollY}`;
};

const showDialogA = () => {
    console.log('B')
    var blur = document.getElementById('blurA');
    blur.classList.toggle('activate')
    var blur=document.getElementById('blurBackgroundA');
    blur.classList.toggle('activate');

    document.getElementById('dialog').classList.add('show')
    const scrollY = document.documentElement.style.getPropertyValue('--scroll-y');
    const body = document.body;
    body.style.position = 'fixed';
    body.style.top = `-${scrollY}`;
};

const closeDialog = () => {
    var blur = document.getElementById('blur');
    blur.classList.toggle('activate')
    var blur=document.getElementById('blurBackground');
    blur.classList.toggle('activate');

    const body = document.body;
    const scrollY = body.style.top;
    body.style.position = '';
    body.style.top = '';
    window.scrollTo(0, parseInt(scrollY || '0') * -1);
    document.getElementById('dialog').classList.remove('show');
    console.log(`-${scrollY}`)
}

const closeDialogA = () => {
    var blur = document.getElementById('blurA');
    blur.classList.toggle('activate')
    var blur=document.getElementById('blurBackgroundA');
    blur.classList.toggle('activate');

    const body = document.body;
    const scrollY = body.style.top;
    body.style.position = '';
    body.style.top = '';
    window.scrollTo(0, parseInt(scrollY || '0') * -1);
    document.getElementById('dialog').classList.remove('show');
    console.log(`-${scrollY}`)
}
window.addEventListener('scroll', () => {
    document.documentElement.style.setProperty('--scroll-y', `${window.scrollY}px`);
});