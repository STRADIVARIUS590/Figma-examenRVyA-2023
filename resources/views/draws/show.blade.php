<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.6.0/p5.min.js" integrity="sha512-3RlxD1bW34eFKPwj9gUXEWtdSMC59QqIqHnD8O/NoTwSJhgxRizdcFVQhUMFyTp5RwLTDL0Lbcqtl8b7bFAzog==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/9b3bebdb5e.js" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$draw->name}}</title>
    
</head>

<body>
    {{-- {{$draw}} --}}

    <input type="text" value="0" id="relx">
    <input type="text" value="0" id="rely">
    <input type="text" value="0" id="console">

    
    <button onclick="bind()">bind</button>
    <button onclick="add('rect')">Cuadrado</button>
    <button onclick="add('ellipse')">Circulo</button>
    <button onclick="addColor('yellow')">amarillo</button>
    <button onclick="addColor('red')">rojo</button>
    <div id="sketch-holder">
    </div>

    
    <div id="app">
        {{--<projects-show
            :user='@json(Auth::user())'
            :project='@json($draw)'
        ></projects-show>--}}
    </div>

    <!--Rutas en vue-->
    @routes

    <!--VUE-->
    @vite('resources/js/app.js')
</body>


<script src="{{asset('/Interface.js') }}"></script>
<script src="{{asset('/Figure.js') }}"></script>

<script> 
const image =JSON.parse(@json($draw->image));

Figure.figures = image.figures || [];

function setup(){
    let canvas =  createCanvas(image.canvas.width, image.canvas.height);
    
    //  posicion de 0,0 del canvas respecto a toda la pantalla
    let relativeX = windowWidth / 2 - image.canvas.width / 2;
    let relativeY = windowHeight / 2 - image.canvas.height / 2


    Interface.relx = relativeX
    Interface.rely = relativeY


    // posiciona el canvas en el centro de la pagina 
    canvas.position(relativeX,  relativeY)
    canvas.parent('sketch-holder');
}

function draw(){
    background('green')
    Figure.draw()
    
    // noLoop();
}

function add(figure){
     Figure.figures.push({
        type: figure,
        posX: Figure.figures.length,
        posY: image.canvas.height / 2,
        height: 150,
        width:50,
        index: Figure.figures.length,
        selected: true
    });
}


function addColor(color){
    
    let this_color = color
    if(!Figure.COLORS[color]){
        this_color = {
            r: color.r,
            g: color.g,
            b: color.b,
       }
    
       Figure.COLORS[crypto.randomUUID()] = color;
    }


    console.table(Figure.COLORS)
    Figure.figures.forEach(element => {
        if(element.selected){
            element.color = this_color;
            // alert(JSON.stringify(element))
        }
    });
}

function bind(){
    // addColor({r:123,g:33 ,b: 12})
     Figure.reverse();
    // save(crypto.randomUUID() +'.png')
}
</script>
</html>