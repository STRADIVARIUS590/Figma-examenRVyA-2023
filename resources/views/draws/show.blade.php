<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.6.0/p5.min.js" integrity="sha512-3RlxD1bW34eFKPwj9gUXEWtdSMC59QqIqHnD8O/NoTwSJhgxRizdcFVQhUMFyTp5RwLTDL0Lbcqtl8b7bFAzog==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Document</title>
</head>
<body>
 
</body>
 


<script> 
const image =JSON.parse(@json($image));

console.log(image);
 
function setup(){
    createCanvas(image.canvas.width, image.canvas.height);
}

function draw(){
    background('green');

    image.figures.forEach(figure => {
        drawFigure(figure);
    });



    // noLoop();
}



function drawFigure(figure){
    console.error(figure);

    switch(figure.type){
        case 'circle': {
            circle(figure.posX ,figure.posY, figure.radius);
            break;
        }

        case 'square':{
            square(figure.posX ,figure.posY, figure.radius)
        }
    }
    // if(figure.type == 'circle'){
        // circle(figure.posX ,figure.posY, figure.radius);
    // }
}

</script>
</html>