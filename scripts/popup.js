const showDialog = () => {

    console.log('A')
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