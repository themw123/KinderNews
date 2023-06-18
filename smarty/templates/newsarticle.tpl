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
    <link href="css/newsarticle.css?v=1.2" rel="stylesheet" type="text/css">
    <script src="service-worker.js?version=er4t4"> </script>

</head>

<body>

    {include file="navbar.tpl"}
    <div class="d-flex flex-column justify-content-center align-items-center">
        <div class="backgr d-flex flex-column justify-content-center align-items-center">
            {if $newsArticle["bild_url"] == null}
                <div class="bildcontainerError container-fluid">
                    <img class="bild custom-shadow" src="img/empty2.svg" class="card-img-top" alt="">
                </div>

            {else}
                <div class="bc bildcontainer container-fluid">
                    <img class="bild custom-shadow" src={$newsArticle["bild_url"]} class="card-img-top" alt=""
                        onerror="this.onerror=null; this.src='img/empty2.svg'; document.querySelector('.bc').classList.remove('bildcontainer'); document.querySelector('.bc').classList.add('bildcontainerError');">
                </div>

            {/if}

            <p class="ptitle">
                {$newsArticle["uebersetzter_titel"]}
            </p>

            <div class="customContainer custom-shadow-article mx-5 mt-4 mb-4">



                <div class="mt-4 ml-4 mr-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="pinfo" id="changeText">Kind</p>
                        <div class="heartandlikes d-flex">
                            <div class="d-flex align-items-center mr-1">
                                <div class="likes fs-4">{$likes}</div>
                            </div>
                            {if $liked == true}
                                <img class="heart" src="./img/heart2.png"></img>
                            {else}
                                <img class="heart" src="./img/heart1.png"></img>
                            {/if}
                        </div>
                    </div>
                </div>


                <p class="ptext">{$newsArticle["uebersetzter_text"]}</p>
                <p class="ptextOriginal hidden">{$newsArticle["originaler_text"]}</p>

            </div>

            <p class="pquestion pquestion1" data-bs-toggle="collapse" href="#answer1">{$newsArticle["frage1"]}</p>
            <div class="answer collapse mx-2" id="answer1">
                <div class="card card-body mb-4">
                    {$newsArticle["answer1"]}
                </div>
            </div>
            <p class="pquestion pquestion2" data-bs-toggle="collapse" href="#answer2">{$newsArticle["frage2"]}</p>
            <div class="answer collapse mx-2" id="answer2">
                <div class="card card-body mb-4">
                    {$newsArticle["answer2"]}
                </div>
            </div>
            <p class="pquestion pquestion3" data-bs-toggle="collapse" href="#answer3">{$newsArticle["frage3"]}</p>
            <div class="answer collapse mx-2" id="answer3">
                <div class="card card-body mb-4">
                    {$newsArticle["answer3"]}
                </div>
            </div>
        </div>

    </div>






    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="js/navbar.js?v=1.0"></script>
    <script src="js/newsarticle.js?v=1.0"></script>

</body>




</html>