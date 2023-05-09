<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.6.0/p5.min.js" integrity="sha512-3RlxD1bW34eFKPwj9gUXEWtdSMC59QqIqHnD8O/NoTwSJhgxRizdcFVQhUMFyTp5RwLTDL0Lbcqtl8b7bFAzog==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
<script src=""></script>
<script src="{{asset('/Figure.js') }}"></script>

    <title>Document</title>
</head>

<body>

    <button onclick="add('square')">Cuadrado</button>
    <button onclick="add('circle')">Circulo</button>
 
</body>



<script> 
const image =JSON.parse(@json($image));

console.log(image);

Figure.figures = image.figures;
function setup(){
    createCanvas(image.canvas.width, image.canvas.height);
}

function draw(){
    background('green');

   Figure.draw()
    console.log(Figure.figures);
    
    // noLoop();
}

function add(figure){
    Figure.figures.push({
        type: figure,
        posX: image.canvas.width / 2,
        posY: image.canvas.height / 2,
        radius: 50
    });

    console.log(Figure.figures);
}

</script>
</html>