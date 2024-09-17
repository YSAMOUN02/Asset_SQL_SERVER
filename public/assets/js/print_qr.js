
let container = document.querySelector(".container");

let grid = document.querySelector("#range_grid");

grid.addEventListener('input',(e)=>{

    document.querySelector("#grid_change").textContent = e.target.value+" Columns";
    container.style.gridTemplateColumns = `repeat(${e.target.value}, 1fr)`;
})



let boxs = document.querySelectorAll(".box_qr");
let rang_size = document.querySelector("#size");
let rang_width = document.querySelector("#width")

let rang_weight = document.querySelector("#weight");

let rang_fsize = document.querySelector("#font-size");

let color = document.querySelector("#color");
rang_size.addEventListener('input',(e)=>{

    document.querySelector("#size_change").textContent = e.target.value+" px";
    boxs.forEach((box)=>{
        box.style.height = e.target.value+'px';

        
    })
})
rang_width.addEventListener('input',(e)=>{

    document.querySelector("#width_change").textContent = e.target.value+" px";
    boxs.forEach((box)=>{
        box.style.width= e.target.value+'px';
      
        
    })
})

rang_weight.addEventListener('input',(e)=>{

    document.querySelector("#weight_change").textContent = e.target.value+" px";
    boxs.forEach((box)=>{
        // box.span.style.fontWeight = e.target.value+'px';
        box.querySelector('span').style.fontWeight = e.target.value;
        
    })
})
rang_fsize.addEventListener('input',(e)=>{

    document.querySelector("#weight_change").textContent = e.target.value+" px";
    boxs.forEach((box)=>{
        // box.span.style.fontWeight = e.target.value+'px';
        box.querySelector('span').style.fontSize = e.target.value+'px';
        
    })
})
color.addEventListener('input',(e)=>{

    boxs.forEach((box)=>{
        // box.span.style.fontWeight = e.target.value+'px';
        box.style.backgroundColor = e.target.value;
        box.querySelector("svg").querySelector('rect').style.fill =  e.target.value;

    })
})

let padding = document.querySelector("#padding");

padding.addEventListener('input',(e)=>{

    document.querySelector("#padding_change").textContent = e.target.value+" px";
    boxs.forEach((box)=>{
        box.style.paddingLeft= e.target.value+'px';
        box.style.paddingRight= e.target.value+'px';
        
    })
})
let paddingY = document.querySelector("#paddingY");

paddingY.addEventListener('input',(e)=>{

    document.querySelector("#paddingY_change").textContent = e.target.value+" px";
    boxs.forEach((box)=>{
        box.style.paddingTop= e.target.value+'px';
        box.style.paddingBottom= e.target.value+'px';
        
    })
})

let content_color = document.querySelector("#c_color");

content_color.addEventListener('input',(e)=>{

    boxs.forEach((box)=>{


        box.querySelector('span').style.color = e.target.value;
        let g =  box.querySelector("svg").querySelector('g').querySelector('g').querySelector('path');
        g.setAttribute('fill', e.target.value);


    })
})

let border = document.querySelector("#border");

border.addEventListener('input',(e)=>{

    document.querySelector("#border_change").textContent = e.target.value+" px";
    boxs.forEach((box)=>{
  
        box.style.border = e.target.value+'px solid';
        
    })
})


let border_color = document.querySelector("#b_color");
border_color.addEventListener('input',(e)=>{

    boxs.forEach((box)=>{

        box.style.borderColor = e.target.value;
   
    })
})