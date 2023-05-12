class Figure {

    static ELLIPSE =  {
        name : 'ellipse',
        props :{
            // aqui podemos poner la propiedades que puede tener especificamente cada tipo de figura para validar si se le pueden asignar a ese tipo
        },
        rectBorder(figure, relx, rely){
            return {
                top: (rely + figure.posY) - (Math.ceil(figure.width / 2)) - 1, 
                left: (relx + figure.posX) - (Math.ceil(figure.height / 2))- 1
            }
        }  
    }

    static figures = []  
  
    static draw(){
    
        Figure.figures.forEach(figure => {

            switch(figure.type){

                case Figure.ELLIPSE.name: {
                   ellipse(figure.posX, figure.posY, figure.height, figure.width);

                //    if(figure.selected){
                        // creo que cada figura deberia tener un div sin que este seleccionada, para detectar el click y que se seleccione

                        // si la figura está seleccionada, creamos un div con su tamaño (solo cuando ese div no existe) 
                        let d = document.getElementById(figure.index);
                        if(d == null){
                            let d = document.createElement('div');
                            let relx = parseInt(document.getElementById('relx').value);
                            let rely = parseInt(document.getElementById('rely').value);
                            let sketch_holeder = document.getElementById("sketch-holder")
                            d.setAttribute('id', figure.index);
                            d.style.height = `${figure.width}px`;
                            d.style.width =  `${figure.height}px`;
                            d.style.position = 'absolute';                      
                            let pos = Figure.ELLIPSE.rectBorder(figure, relx, rely)
                            d.style.top = (pos.top) + 'px';
                            d.style.left = (pos.left) + 'px';
                            sketch_holeder.appendChild(d);  
                        
                            ///
                            d.draggable = true;
                            // d.style.border = '1px solid red'
                        
                        
                            d.addEventListener('mouseover', function(e){
                                e.target.style.border = '1px solid red'
                                figure.selected = true
                            })

                            
                            d.addEventListener('mouseout', function(e){
                                e.target.style.border = 'transparent'
                                figure.selected = false
                            })
                            // añadimos el listener que mueve la figura y el div segun el movimiento del raton
                            d.addEventListener("drag" ,function(e){  
                                // movemos la figura
                                figure.selected = true
                                figure.posX = mouseX
                                figure.posY = mouseY
                                // movemos el div 
                                let pos = Figure.ELLIPSE.rectBorder(figure, relx, rely)
                                e.target.style.top = (pos.top) + 'px';
                                e.target.style.left = (pos.left ) + 'px';
                                e.target.style.border = '1px solid blue'
                            }); 

                            d.addEventListener("dragend" ,function(e){  
                                e.target.style.border = '1px solid red'
                            }); 
                        // }
                    }            
                   break;
                }
        
                case 'rect':{
                    rect(figure.posX, figure.posY, figure.height, figure.width);
                    break;
                }
                case 'line':{
                     line(figure.posX, figure.posY, figure.posX2, figure.posY2);
                }
            }
    });
    

    } 
        static selected(){
        // obteneer elemento seleccionado
    }
}