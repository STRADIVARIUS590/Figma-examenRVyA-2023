<!doctype html>
<html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>Sugma</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body class="background">
    <div class="px-4 py-2 w-100 headerBar text-light d-flex">
        <h1 class="mt-2 col font titleName"><b>SUGMA</b></h1>
        
        <a class="btn landingbutton py-0 font mb-1" href="{{route('login')}}">
            <b>Comenzar</b>
        </a>
    </div>
    <div class="landingshadow">
        <h5 class="landingtext font">Donde la creatividad y la funcionalidad son uno solo</h5>
    </div>
</body>
</html>

<style>
.background{
    background-image: url("/images/landingbg.png");
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    height: 100vh;
    width: 100vw;
}

.headerBar{
    background: linear-gradient(180deg, #AF259A 0%, #132843 100%);
}
a{
    text-decoration: none;
}
.landingtext{
    position: absolute;
    width: 496px;
    height: 309px;
    left: 5%;
    top: 20%;

    font-size: 60px;
    line-height: 69px;

    color: #FFFFFF;
}
.landingbutton{
    background: #DCBF57;
    border-radius: 10px;

    font-size: 25px;
    line-height: 58px;
}
.font{
    font-family: 'Yeseva One';
    font-style: normal;
    font-weight: 400;
}
.titleName
{
    font-size: 35px;
}
@media (max-width: 1200px) {
  h1 {
    width: 100%;
  }
}
</style>