class Interface{

    // posicion del punto 0,0 del canvas, respecto a todo el documento 
    static relx
    static rely

    // donde ponermos los divs qeu rodean a las figuras
    static sketch_holder

    static border(figure, e){
            if(figure.selected){
               e.target.style.border = '1px solid blue'
           }else{
               e.target.style.border = '1px solid red'
           } 
    }

    static createDiv(){}
}