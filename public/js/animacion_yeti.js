const d = document;

const $yetiImagen = d.querySelector(".yeti__imagen");
const tiempo = 800;


function cambiarEstadoDeLYeti(flag){
    if(flag){
        $yetiImagen.style.transform = `scale(1.1)`;
    }
    else{
        $yetiImagen.style.transform = `scale(1)`;

    }
}

setInterval(()=>{
    setTimeout(()=>{
        cambiarEstadoDeLYeti(true);
        setTimeout(()=>{
            cambiarEstadoDeLYeti(false);
        },tiempo)
    },tiempo )
},2000);
