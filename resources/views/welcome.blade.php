<!doctype html>
<html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Figma</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


</head>

<body class="background">

    <h1 class="text-center text-light">(Parte del lalo)</h1>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4">

                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">Figma</h5>
                        <p class="text-muted">Acceso</p>
                    </div>
                    <div class="p-2 mt-4">
                        <form class="needs-validation" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="useremail" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" required="" placeholder="Ingrese un email">
                                @error('email')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label" for="password-input">Password</label>
                                <div class="position-relative auth-pass-inputgroup">
                                    <input type="password" class="form-control pe-5 password-input @error('login') is-invalid @enderror" id="password" name="password" required autocomplete="current-password" placeholder="* * * * *" aria-describedby="passwordInput" required>
                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                    @error('password')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                <h5 class="fs-13">Password must contain:</h5>
                                <p id="pass-length" class="invalid fs-12 mb-2">Minimum <b>8 characters</b></p>
                                <p id="pass-lower" class="invalid fs-12 mb-2">At <b>lowercase</b> letter (a-z)</p>
                                <p id="pass-upper" class="invalid fs-12 mb-2">At least <b>uppercase</b> letter (A-Z)</p>
                                <p id="pass-number" class="invalid fs-12 mb-0">A least <b>number</b> (0-9)</p>
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <input id="checkbox1" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="checkbox1">{{ __('Recordarme') }}</label>
                                </div>
                                <a class="link" href="{{ route('forgot.password') }}">
                                    Olvidaste tu contraseña?
                                </a>
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-success w-100" type="submit">Log In</button>
                            </div>
                        </form>                                                
                    </div>
                </div>
                <!-- end card body -->
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>

    <!-- particles js -->
    <script src="{{ asset('libs/particles.js/particles.js') }}"></script>
    <!-- particles app js -->
    <script src="{{ asset('js/pages/particles.app.js') }}"></script>
    <!-- validation init -->
    <script src="{{ asset('js/pages/form-validation.init.js') }}"></script>
    <!-- password create init -->
    <script src="{{ asset('js/pages/passowrd-create.init.js') }}"></script>

    <script type="text/javascript">
        // Desactiva click derecho
        document.oncontextmenu = function(){ return false }

        // Toggle password
        const togglePassword = document.getElementById("toggle-password");
        if (togglePassword) {
            togglePassword.addEventListener('click', function() {
            let x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
            });
        }

        function validateLogin(target){
            if (grecaptcha.getResponse()){

                var token_google = grecaptcha.getResponse();
                $("#token_google").val(token_google)
                return true

            }else{
                Swal.fire(
                    '',
                    'Es necesario verificar la casilla',
                    'warning'
                )
                return false;
            }
        }

        /*hola*/
        console.clear();
        var cssRule =
            "color: rgb(0, 0, 0);" +
            "font-size: 60px;" +
            "font-weight: bold;" +
            "text-shadow: 1px 1px 5px rgb(0, 0, 0);" +
            "filter: dropshadow(color=rgb(0, 0, 0), offx=1, offy=1);";
        console.log("%c¡Detente!", cssRule);
        setTimeout(console.log.bind(console, '%cEsta función del navegador está pensada para desarrolladores. Si alguien te indicó que copiaras y pegaras algo aquí para habilitar una función de E-commerce o para ´hackear´ la cuenta de alguien, se trata de un fraude. Si lo haces, esta persona podrá acceder a tu cuenta.', 'color: #9e202ad1;font-size: 30px;'), 0);
    </script>
</body>
</html>

<style>
.background{
    background-image: url("/images/fondo.png");
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    height: 89.75vh;
    width: 100vw;
}
</style>