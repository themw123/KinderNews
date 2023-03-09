<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid ">
        <div class="row">
            <div class="col-auto">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="col d-flex align-items-center justify-content-sm-center justify-content-xs-start titlediv">
                <a class="navbar-brand" href="#">KinderNews</a>
            </div>
        </div>
        <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
            aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Dark offcanvas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link" id="nav-home" aria-current="page" href="./?home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="nav-news" href="./authentication.php?news">News</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>