window.addEventListener("scroll", function(){
    var nav = document.querySelector("div");
    nav.classList.toggle("container_nav--abajo", window.scrollY>0);
})