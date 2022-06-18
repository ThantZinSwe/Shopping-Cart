var loader1 = document.getElementById("pre-loader1");
var loader2 = document.getElementById("pre-loader2");
window.addEventListener("load",function(){
    loader1.style.display = "none";
    loader2.style.display = "none";
});

const slider = document.querySelectorAll(".slide-in");
const appearOptions = {
    threshold:0,
    rootMargin: "0px 0px -250px 0px",
};

const appearOnScroll = new IntersectionObserver(function(entries,appearOnScroll){
    entries.forEach(entry => {
        if(!entry.isIntersecting){
            return;
        }else{
            entry.target.classList.add('appear');
            appearOnScroll.unobserve(entry.target);
        }
    });
},appearOptions);

slider.forEach(slide => {
    appearOnScroll.observe(slide);
});
