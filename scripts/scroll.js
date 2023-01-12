window.addEventListener("scroll", function(){
    var nav = document.getElementsByClassName("container_nav");
    nav[0].classList.toggle("container_nav--abajo", window.scrollY>0);
})