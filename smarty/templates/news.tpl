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
    <link href="css/news.css?v=1.1" rel="stylesheet" type="text/css">

</head>

<body>


    {include file="navbar.tpl"}

    {if !isset($errors) &&!isset($messages)}
        <div class="alert alert-hidden">leer</div>
    {/if}

    {if (isset($errors))}
        {foreach item=error from=$errors}
            {if ($error != false)}
                <div class="alert alert-warning">{$error}</div>
            {/if}
        {/foreach}
    {/if}
    {if (isset($messages))}
        {foreach item=message from=$messages}
            <div class="alert alert-custom">{$message}</div>
        {/foreach}
    {/if}

    <div class="custom row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xxl-6 g-4 mt-1 mb-4">
        {foreach $news as $article}
            <div class="col">
                <a href=" ./?news&id={$article["id"]}">
                    <div class="card border-0 h-100 ">
                        {if $article["bild_url"] == "error"}
                            <img class="bilder rounded-top" src='img/empty.svg' class="card-img-top" alt="">
                        {else}
                            <img class="bilder rounded-top" src={$article["bild_url"]} class="card-img-top" alt=""
                                onerror="this.src='img/empty.svg'">
                        {/if}
                        <div class="card-body d-flex flex-column">
                            <div class="card-title d-flex justify-content-between">
                                <p class="card-head">
                                    {$article["quelle"]}
                                </p>
                                {if {$article["likes"]} > 0}
                                    <div class="heartandlikes d-flex align-items-center">
                                        <div class="likes fs-4">{$article["likes"]}</div>
                                        {if {$article["liked"]} == true}
                                            <img class="heart1" src="./img/heart2.png"></img>
                                        {else}
                                            <img class="heart3" src="./img/heart3.png"></img>
                                        {/if}
                                    </div>
                                {/if}
                            </div>
                            <h5 class="card-title">{$article["uebersetzter_titel"]}</h5>
                            <p class="card-preview mt-auto mb-auto">{$article["uebersetzte_preview"]}</p>
                            <p class="card-foot">{$article["date"]}</p>
                        </div>
                    </div>
                </a>
            </div>
        {/foreach}
    </div>





    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="js/navbar.js?v=1.0"></script>
    <script src="js/news.js"></script>


</body>




</html>