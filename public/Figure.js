class Figure {

    static COLORS = {
        
        yellow: {
            r : 255,
            g : 204, 
            b : 100
        },
        red: {
            r : 255,
            g : 0,
            b : 0
        }
    }
    static ELLIPSE =  {
        name : 'ellipse',
        props :{
            // aqui podemos poner la propiedades que puede tener especificamente cada tipo de figura para validar si se le pueden asignar a ese tipo
        },
        rectBorder(figure, relx, rely){
            return {
                top: (rely + figure.posY) - ((abs(figure.height) / 2)), 
                left: (relx + figure.posX) -((abs(figure.width) / 2)),
                height: abs(figure.height),
                width: abs(figure.width),
            }
        },
    }
    static RECT = {
        name: 'rect',
        rectBorder(figure, relx, rely){
            return {
                top: (rely + figure.posY + (figure.height / 2))  - ((abs(figure.height) / 2)), 
                left:(relx + figure.posX + (figure.width / 2))   - ((abs(figure.width) / 2)) ,
                width: abs(figure.width) + 2,
                height: abs(figure.height) + 2
            }
        }
    }

    static LINE = {
        name: 'line',
        rectBorder(figure, relx, rely){   
            return {
                top: (rely + (figure.posY < figure.posY2 ? figure.posY : figure.posY2)), 
                left: (relx + (figure.posX < figure.posX2 ? figure.posX : figure.posX2)),
                width: abs(figure.posX2 - figure.posX) + 5,
                height: abs(figure.posY2 - figure.posY) + 5,
            }
        }
    }

    static KEYS = {
        ellipse : Figure.ELLIPSE,
        rect : Figure.RECT,
        line : Figure.LINE
    } 
     

    static figures = []  
  
    static draw(){
    
        document.getElementById('console').value = Figure.selected().indexes
        Figure.figures.forEach(figure => {

            let c = figure.color;
            let color = Figure.COLORS[figure.color] || c;
            if(color){
                fill(color.r, color.g, color.b)   
            }else{
                noFill();
            }
            switch(figure.type){

            //// ///////////////////////////// CIRCLE
                case Figure.ELLIPSE.name: {
                    
                    ellipse(figure.posX, figure.posY, figure.width, figure.height);

                        // si la figura está seleccionada, creamos un div con su tamaño (solo cuando ese div no existe) 

                        if(!figure.hasNode ){
                            figure.hasNode = true 
                            let d = document.createElement('div');
                            let relx = Interface.relx
                            let rely = Interface.rely
                            let sketch_holeder = document.getElementById("sketch-holder")
                            d.setAttribute('id', figure.index);
                            d.setAttribute('type', figure.type);
                            let pos = Figure.KEYS[figure.type].rectBorder(figure, relx, rely)
                            d.style.height = `${pos.height}px`;
                            d.style.width =  `${pos.width}px`;
                            d.style.top = `${pos.top}px`;
                            d.style.left =  `${pos.left}px`;
                            d.style.position = 'absolute';                      
                            sketch_holeder.appendChild(d);  
                            ///
                            d.draggable = true;
                            // d.style.border = '1px solid red'
                        
                        
                            d.addEventListener('mouseover',(e) => { Interface.border(figure, e)})

                            d.addEventListener('dblclick', (e) => {
                                figure.selected = !figure.selected
                                Interface.border(figure, e)
                            })

                            d.addEventListener('mouseout', function(e){
                                e.target.style.border = 'transparent'
                            })
                            // añadimos el listener que mueve la figura y el div segun el movimiento del raton
                            d.addEventListener("drag" ,function(e){  
                            
                                figure.selected = true
                    
                                // console.log(e.offsetX);
                                // movemos la figura

                                if(e.ctrlKey){
                                    figure.height = mouseY
                                    figure.width = mouseX
                                }else{                                    
                                   
                                    figure.posX = mouseX
                                    figure.posY = mouseY
                                }

                                let type = e.target.getAttribute('type');
                                let pos =  Figure.KEYS[type].rectBorder(figure, relx, rely)
                            

                                // movemos el div 
                                d.style.height = `${pos.height}px`;
                                d.style.width =  `${pos.width}px`;
                                d.style.top = `${pos.top}px`;
                                d.style.left =  `${pos.left}px`;
                                e.target.style.border = '1px solid blue'
                            });

                    }            
                   break;
                }
        
                ////////////////////////RECTTTTTTTTTTTT
                case Figure.RECT.name:{
                    rect(figure.posX, figure.posY, figure.width, figure.height);
                    
                    if(!figure.hasNode){
                        figure.hasNode = true 
                        let d = document.createElement('div');
                        let relx = Interface.relx
                        let rely = Interface.rely
                        let sketch_holeder = document.getElementById("sketch-holder")
                        d.setAttribute('id', figure.index);
                        d.setAttribute('type', figure.type);
                        let pos = Figure.KEYS[figure.type].rectBorder(figure, relx, rely)
                        d.style.height = `${pos.height}px`;
                        d.style.width =  `${pos.width}px`;
                        d.style.position = 'absolute';                      
                        d.style.top = `${pos.top}px`;
                        d.style.left =  `${pos.left}px`;
                        sketch_holeder.appendChild(d); 
                        d.style.border = '1px solid blue'


                        d.draggable = true;
                        // d.style.border = '1px solid red'
                    
                    
                        d.addEventListener('mouseover',(e) => { Interface.border(figure, e)})

                        d.addEventListener('dblclick', (e) => {
                            figure.selected = !figure.selected
                            Interface.border(figure, e)
                        })

                        d.addEventListener('mouseout', function(e){
                            e.target.style.border = 'transparent'
                        })
                        // añadimos el listener que mueve la figura y el div segun el movimiento del raton
                        d.addEventListener("drag" , function(e){  
                            // movemos la figura

                            figure.selected = true;


                            if(e.ctrlKey){
                                figure.height = mouseY
                                figure.width = mouseX
                            }else{                                    
                               
                                figure.posX = mouseX
                                figure.posY = mouseY
                            }
                            // movemos el div 
                            let type = e.target.getAttribute('type');
                            let pos =  Figure.KEYS[type].rectBorder(figure, relx, rely)

                            e.target.style.height = `${pos.height}px`;
                            e.target.style.width =  `${pos.width}px`;
                            e.target.style.top = `${pos.top}px`;
                            e.target.style.left =  `${pos.left}px`;
                            e.target.style.border = '1px solid blue'
                        });
                    }
                    break;
                }
                case 'line':{

           /*          figure.height = abs(figure.posX2 - figure.posX)
                    figure.width = abs(figure.posY2 - figure.posY) */ 
                    // figure.height = 
                     line(figure.posX, figure.posY, figure.posX2, figure.posY2);
/* 
                     rect(figure.posX < figure.posX2 ? figure.posX : figure.posX2,
                         figure.posY < figure.posY2 ? figure.posY : figure.posY2,
                          figure.width, figure.height); */
                    if(!figure.hasNode){
                        figure.hasNode = true
                        let d = document.createElement('div');
                        let relx = Interface.relx
                        let rely = Interface.rely
                        let sketch_holeder = document.getElementById("sketch-holder")
                        d.setAttribute('id', figure.index);
                        d.setAttribute('type', figure.type);
                        let pos = Figure.KEYS[figure.type].rectBorder(figure, relx, rely)
                        // console.table(pos)
                        d.style.height = `${pos.height}px`;
                        d.style.width =  `${pos.width}px`;
                        d.style.position = 'absolute';                      
                        d.style.top = `${pos.top}px`;
                        d.style.left =  `${pos.left}px`;
                        sketch_holeder.appendChild(d); 
                        // d.style.border = '1px solid blue'

                        d.addEventListener('mouseover',(e) => { Interface.border(figure, e)})

                        d.addEventListener('dblclick', (e) => {
                            figure.selected = !figure.selected
                            Interface.border(figure, e)
                        })

                        d.addEventListener('mouseout', function(e){
                            e.target.style.border = 'transparent'
                        })

                        d.addEventListener("drag" , function(e){  
                            // movemos la figura

                            figure.selected = true;
                            
                            let type = e.target.getAttribute('type');
                            let pos =  Figure.KEYS[type].rectBorder(figure, relx, rely)

                            if(e.ctrlKey){
                             
                            }else{           

                                //todo :  validar cuando se mueve toda la linea o mover los puntos x, y, x2 y y2  
                                
                                
                                // figure.posX = mouseX
                                // figure.posY = mouseY
                                // figure.posX2 = figure.posX + pos.width
                                //  console.log('X', pos.isNegX);
                                // console.log('Y', pos.isNegY);

                                /* 
                width: abs(figure.posX2 - figure.posX) + 5,
                height: abs(figure.posY2 - figure.posY) + 5 
                 */
                            }

                            // movemos el div 
                           

                            e.target.style.height = `${pos.height}px`;
                            e.target.style.width =  `${pos.width}px`;
                            e.target.style.top = `${pos.top}px`;
                            e.target.style.left =  `${pos.left}px`;
                            e.target.style.border = '1px solid blue'
                        });
                    }
                }
            }

          
    });
    

    } 
    static selected(){
    let sel = {
        indexes: [],
        figures: []
    }
    Figure.figures.forEach((ele) => {
        if(ele.selected){
            sel.indexes.push(','+ ele.index);
            sel.figures.push(ele);
        }
    })
    return sel;
    }

    // // capas (invierte posicion de figuras seleccionadas) 
    static reverse() {
    console.table(Figure.figures);
    let arr = Figure.selected();
    arr = arr.figures.reverse();
    let ct = 0;
    let ele = null;
    Figure.figures.forEach(e =>{
        if(e.selected){
            ele = arr.shift();
            // document.getElementById(e.index).setAttribute('id', ele.index)
            // document.getElementById(ele.index).setAttribute('id', ct)
            ele.index = ct
            Figure.figures.splice(ct, 1, ele);
        }
        ct++
        })
    }
}