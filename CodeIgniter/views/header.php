<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">

        <!-- Responsive web design -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Bootstrap CSS 4.5.3 import from CDN -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" 
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

        <!-- Link CSS file -->
        <link rel="stylesheet"  href="CodeIgniter/assets/css/CodeIgniter.css"> 

        <title>  </title>
    </head>

    <body>
        <div class="container"> 
            <!-- PAGE HEAD -->
            <header> 
                <!-- Logo Jarditou -->
                <div class="row">
                    <div class="col-3 p-3 d-none d-sm-none d-md-block">  
                        <img src="<?php echo base_url("assets/photos/jarditou_logo.jpg"); ?>" alt="logo" title="photo" class="img-fluid"> 
                    </div>
                    <div class="col-9 d-none d-sm-none d-md-block">  
                        <h1 class="text-right px-5 py-3"> <b>La qualité depuis 70 ans</b> </h1>
                    </div>
                </div>
                <!-- Navigation Bar -->
                    <nav class="navbar navbar-expand-md navbar-light" style="background-color:lightgray; border-radius: 10px;">
                        <!-- Collapsing The Navigation Bar -->
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" 
                        aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                            <ul class="col-12 navbar-nav mr-auto mt-2 mt-lg-0 nav justify-content-center" style="font-size: xx-large">
                                <li class="nav-item"  style="margin-left: 50px;">
                                    <a class="nav-link"  href="<?php echo site_url("produits/acceuil");?>"> Acceuil <span class="sr-only">(current)</span> </a>
                                </li>
                                <li class="nav-item"  style="margin-left: 50px;">
                                    <a class="nav-link"  href="<?php echo site_url("produits/liste");?>"> Tableau </a>
                                </li>
                                <li class="nav-item"  style="margin-left: 50px;">
                                    <a class="nav-link"  href="<?php echo site_url("users/contact");?>"> Contact </a>    
                                </li>
                            </ul>
                        </div>
                    </nav>
                <!-- Image "Promotion sr lames de terrase" -->
                <div class="row"  style="margin:20px 0 20px 0">
                    <div class="col-12">
                        <img src="<?php echo base_url("assets/photos/promotion.jpg"); ?>" alt="promotion" title="photo" class="img-fluid w-100"> 
                    </div>
                </div>
            </header>
        </div>    
    </body>
</html>



    