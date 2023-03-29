<!DOCTYPE HTML>
<html>

<head>
    <title>KinderNews</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Für iphones. Sonnst ist über der Navbar der Hintergrund Rot. -->
    <meta name="theme-color" content="#2e2c2a" />
    <link rel="manifest" href="/manifest.json">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="css/alle.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/settings.css" rel="stylesheet" type="text/css">
    <script src="service-worker.js"> </script>
</head>

<body>

    {include file="navbar.tpl"}
    <div class="container d-flex justify-content-center align-items-center h-100">


        <div class="col-md-5 mx-auto mt-5">
            <div class="alert alert-hidden">leer</div>

            <div class="card text-bg-light custom-shadow rounded-4 mb-4">
                <div class="card-header fs-5 fw-bold">Einstellungen</div>
                <div class="card-body d-flex flex-column">
                    <div>
                        <div class="d-flex flex-row align-items-center">
                            <p class="customFontSize pe-3 fw-bold">Benutzername: </p>
                            <p class="customFontSize">{$name}</p>
                        </div>
                        <div class="d-flex flex-row align-items-center">
                            <p class="customFontSize pe-3 fw-bold">Email: </p>
                            <p class="customFontSize">{$email}</p>
                        </div>
                        <div class="d-flex flex-row align-items-center">
                            <p class="customFontSize pe-3 fw-bold">Rolle: </p>
                            <p class="customFontSize">{$admin}</p>
                        </div>


                        <div class="card text-bg-light">
                            <div class="card-header">News aktualisieren</div>
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <p class="text-center customFontSize">Achtung! Es werden die neusten News (maximal 10)
                                    geladen und
                                    anschließend
                                    übersetzt. Nur Administratoren sind berechtigt. Dieser Vorgang kann mehrere Minuten
                                    dauern.
                                </p>
                                <button class="btn btn-dark loadingButton" type="button" {$buttonState}>
                                    <span class="spinner-border spinner-border-sm buttonSpinner" role="status"
                                        aria-hidden="true"></span>
                                    <div class="buttonText">aktualisieren</div>
                                </button>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>





    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="js/navbar.js"></script>
    <script src="js/settings.js"></script>
    <script src="push.js"></script>
</body>




</html>