class Interface{



    static border(figure, e){
            if(figure.selected){
               e.target.style.border = '1px solid blue'
           }else{
               e.target.style.border = '1px solid red'
           } 
    }

    static createDiv(){}
}