function showModalDialog(idDialog){
    const modal = document.getElementById(idDialog);
    setTimeout(() => {
        modal.classList.add('mostrarModal')
    }, 1);
    modal.showModal();
}

function hideModalDialog(idDialog){
    const modal = document.getElementById(idDialog);
    modal.classList.remove('mostrarModal');
    modal.addEventListener('animationend', closeModal);
    modal.classList.add('close');

    function closeModal() {
        modal.close();
        modal.classList.remove('close');
        modal.removeEventListener('animationend', closeModal);
    }
}