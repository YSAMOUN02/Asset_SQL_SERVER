
let container = document.querySelector(".container");

let grid = document.querySelector("#range_grid");

grid.addEventListener('input',(e)=>{

    document.querySelector("#grid_change").textContent = e.target.value+" Columns";
    container.style.gridTemplateColumns = `repeat(${e.target.value}, 1fr)`;
})
let gap = document.querySelector("#range_gap");
gap.addEventListener('input',(e)=>{
    if(document.querySelector("#gap_change")){
        document.querySelector("#gap_change").textContent = e.target.value+" px";
    }

    container.style.gap = e.target.value+'px';
})


let boxs = document.querySelectorAll(".box_qr");
let rang_size = document.querySelector("#size");
let rang_width = document.querySelector("#width")

let rang_weight = document.querySelector("#weight");

let rang_fsize = document.querySelector("#font-size");

let color = document.querySelector("#color");
rang_size.addEventListener('input',(e)=>{
    if(document.querySelector("#size_change")){
        document.querySelector("#size_change").textContent = e.target.value+" px";
    }

   if(boxs){
    boxs.forEach((box)=>{
        if(box){
            box.style.height = e.target.value+'px';
        }


    })
   }
})
rang_width.addEventListener('input',(e)=>{

    document.querySelector("#width_change").textContent = e.target.value+" px";
    boxs.forEach((box)=>{
        box.style.width= e.target.value+'px';


    })
})

rang_weight.addEventListener('input',(e)=>{

    document.querySelector("#weight_change").textContent = e.target.value+" px";
    if(boxs){
        boxs.forEach((box)=>{
            // box.span.style.fontWeight = e.target.value+'px';
            if(box){
                if(box.querySelector('span')){
                    box.querySelector('span').style.fontWeight = e.target.value;
                }

            }


        })
    }
})
rang_fsize.addEventListener('input',(e)=>{
    if(document.querySelector("#weight_change")){
        document.querySelector("#weight_change").textContent = e.target.value+" px";
    }

    if(boxs){
        boxs.forEach((box)=>{
            // box.span.style.fontWeight = e.target.value+'px';
            if(box){
                if(   box.querySelector('span')){
                    box.querySelector('span').style.fontSize = e.target.value+'px';
                }


            }
        })
    }
})
color.addEventListener('input',(e)=>{

    boxs.forEach((box)=>{
        // box.span.style.fontWeight = e.target.value+'px';
        box.style.backgroundColor = e.target.value;
        if(box.querySelector("svg")){
            if(box.querySelector("svg").querySelector('rect')){
                box.querySelector("svg").querySelector('rect').style.fill =  e.target.value;
            }

        }


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
    if(boxs){
        boxs.forEach((box)=>{
            if(box.querySelector('span')){
                box.querySelector('span').style.color = e.target.value;
                let g =  box.querySelector("svg").querySelector('g').querySelector('g').querySelector('path');
                if(g){
                    g.setAttribute('fill', e.target.value);
                }
            }




        })
    }

})

let border = document.querySelector("#border");

border.addEventListener('input',(e)=>{

    document.querySelector("#border_change").textContent = e.target.value+" px";
    boxs.forEach((box)=>{
        if(existing_b_color != ""){
            box.style.border = e.target.value+'px solid'+existing_b_color;
        }
        else{
            box.style.border = e.target.value+'px solid';
        }

    })
})

let existing_b_color="";
let border_color = document.querySelector("#b_color");
border_color.addEventListener('input',(e)=>{
    if(boxs){
        boxs.forEach((box)=>{

            if(box){
                box.style.borderColor = e.target.value;
                existing_b_color = e.target.value;
            }

        })
    }

})

function close_list_print(){
    document.querySelector('#list').style.display="none";
}

let td_mom = document.querySelectorAll('#td');
let th_mom = document.querySelectorAll('#th');

// All State set to 1;
let state_hide = [1,1,1,1,1,1,1,1,1,1,1,1,1,1];

function remove_child_table(hide){



    if(state_hide[hide-1] == 1){
        let th = Array.from(th_mom);

        th.map((child)=>{

            let target = child.querySelector('th:nth-child('+hide+')');
            target.style.display = 'none';

        })
        let td = Array.from(td_mom);
        td.map((child)=>{
            let target = child.querySelector('td:nth-child('+hide+')')
            target.style.display = 'none';
        })
        state_hide[hide-1] = 0;
    }else{
        let th = Array.from(th_mom);

        th.map((child)=>{

            let target = child.querySelector('th:nth-child('+hide+')');
            target.style.display = 'block';

        })
        let td = Array.from(td_mom);
        td.map((child)=>{
            let target = child.querySelector('td:nth-child('+hide+')')
            target.style.display = 'block';
        })
        state_hide[hide-1] = 1;
    }
    console.log(state_hide);
}

function remove_QR(id){
    console
    document.querySelector(id).remove();
}

