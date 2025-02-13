console.log('Hello from script.js');

document.addEventListener("DOMContentLoaded", (event) => {
    // fonction texte allongement
    const textEvent = document.querySelectorAll('.text-event');
    // console.log(textEvent)
    textEvent.forEach((text) =>{
        text.addEventListener('click', function(){
            if(text.classList.contains('truncate')){
                text.classList.remove('truncate');
                text.classList.add('text-clip');
            } else if(text.classList.contains('text-clip')){
                text.classList.remove('text-clip');
                text.classList.add('truncate');
            }
        })
    })
})