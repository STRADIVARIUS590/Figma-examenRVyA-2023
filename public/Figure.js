class Figure {

    static figures = []
    constructor(posX, posY){

        // this.postX = posX
        // this.postY = posY
    }

  
  
    static draw(){
        // console.error(figure);
    

        Figure.figures.forEach(figure => {

            switch(figure.type){
                case 'circle': {
                   let  f = circle(figure.posX, figure.posY, figure.radius);
                    console.log(f);
                    // f.id('qweq');
                    // f.mouseover(Figure.listen);
                    break;
                }
        
                case 'square':{
                    square(figure.posX, figure.posY, figure.radius)
                    break;
                }
            }
        });
    

       


        // Figure.figures.push(figure);
        // if(figure.type == 'circle'){
            // circle(figure.posX ,figure.posY, figure.radius);
        // }
    }   


    static listen(){
        console.log('listen');
    }


}