<!DOCTYPE HTML>
<html>

<head>
    <title>KinderNews</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Für iphones. Sonnst ist über der Navbar der Hintergrund Rot. -->
    <meta name="theme-color" content="#2e2c2a" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="css/alle.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/newsArticle.css" rel="stylesheet" type="text/css">

</head>

<body>

    {include file="navbar.tpl"}
    <div class="d-flex flex-column justify-content-center align-items-center">
        <div class="backgr d-flex flex-column justify-content-center align-items-center">
            <div class="bildcontainer container-fluid">
                <img class="bild custom-shadow" src={$newsArticle["bild_url"]} class="card-img-top" alt=""
                    onerror="this.onerror=null; this.src='./img/empty.png'; ">
            </div>

            <p class="ptitle">
                {$newsArticle["uebersetzter_titel"]}
            </p>

            <div class="customContainer custom-shadow-article mx-5 mt-4 mb-4">



                <div class="mt-4">
                    <div class="d-flex align-items-center">
                        <div class="ml-3">
                            <img class="me-2" id="changeText" src="./img/document.png"></img>
                        </div>
                        <div class="heartandlikes d-flex justify-content-end w-100 mr-4">
                            {if $liked == true}
                                <div class="mr-1">
                                    <img class="heart" src="./img/heart2.png"></img>
                                </div>
                            {else}
                                <div class="mr-1">
                                    <img class="heart" src="./img/heart1.png"></img>
                                </div>
                            {/if}
                            <div class="d-flex align-items-center">
                                {if $likes == 0}
                                    <div class="likes">{$likes}</div>
                                {else}
                                    <div class="likes">{$likes}</div>
                                {/if}
                            </div>
                        </div>
                    </div>
                </div>







                <p class="ptext">{$newsArticle["uebersetzter_text"]}</p>
                <p class="ptextOriginal hidden">{$newsArticle["originaler_text"]}</p>
            </div>


        </div>

    </div>






    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="js/navbar.js"></script>
    <script src="js/newsArticle.js"></script>


</body>




</html>