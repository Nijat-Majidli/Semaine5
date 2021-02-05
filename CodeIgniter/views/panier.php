<?php 
    if (isset($this->session->login) && isset($this->session->role)) 
    {
        echo '<h6 style="margin-left:20px"> Bonjour ',$this->session->role, ' ', $this->session->login, '<br> Vous êtes connecté ! </h6>' ;
    } 
    else    // Pas connecté
    {  
        redirect("Users/login");
    }
?>


<!-- Pour afficher toutes les erreurs en une seule fois via la fonction validation_errors(): -->
<?php echo validation_errors(); ?>  


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">

        <!-- Responsive web design -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

         <!-- Font Awesome import from CDN -->
         <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

        <!-- Bootstrap CSS 4.5.3 import from CDN -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" 
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

        <!-- Link CSS file -->
        <link rel="stylesheet"  href="CodeIgniter/assets/css/CodeIgniter.css"> 

        <title> Panier </title>
    </head>


    <!-- PAGE MAIN CONTENT -->
    <body>
        <div class="container"> 
            <div class="table-responsive"  style="width:90%;  margin:auto;"> 
                <!-- Table of panier -->
                    <?php 
                if (isset($produitsPanier))
                {
                    ?>
                    <table class="table table-bordered table-striped"  style="text-align:center"> 
                        <thead class="thead-light" >
                            <tr class="font-weight-bolder">
                                <th scope="col"> Produit </th>
                                <th scope="col"> Prix </th>
                                <th scope="col"> Quantité </th>
                                <th scope="col"> Prix total </th>
                            </tr>   
                        </thead>
                        <tbody>
                            <?php 
                            $montantTotal=0; 
                        
                            foreach ($produitsPanier as $row)   // Ici on récupere la clé 'produitsPanier' du tableau $aListe qui se trouvent dans la méthode afficherPanier() de controlleur Panier.php     
                            {                                   // Ici la clé est transformée en variable, donc on écrit $produitsPanier et non pas echo $aListe["produitsPanier"]                                  
                                ?>    
                                <tr>
                                    <td> 
                                        <div> 
                                            <?php  echo $row['pro_libelle']; ?>

                                            <!-- Supprimer button -->
                                            <!--Ici on envoie 1 argument (pro_id) au méthode supprimerProduit() qui se trouve dans controlleur Panier.php -->
                                            <a href="<?php echo site_url("panier/supprimerProduit/".$row['pro_id']); ?>"  style="margin-left: 30px"> 
                                                Supprimer  
                                            </a>  
                                        </div>
                                    </td>
                                    <td> 
                                        <div> 
                                            <?php  echo $row['pro_prix']; ?>
                                        </div>
                                    </td>
                                    <td> 
                                        <div> 
                                            <?php  echo $row['pro_qte']; ?>
                                            
                                            <!-- Modifier button -->
                                            <!--Ici on envoie 1 argument (pro_id) au méthode modifierQuantite() qui se trouve dans controlleur Panier.php -->
                                            <a href="<?php echo site_url("panier/modifierQuantite/".$row['pro_id']);?>"  style="margin-left: 30px"> 
                                                Modifier
                                            </a> 

                                        </div>
                                    </td>
                                    <td> 
                                        <div> 
                                            <?php echo $Montant = $row['pro_prix'] * $row['pro_qte']; ?>
                                        </div>
                                    </td>
                                    
                                    <?php $montantTotal += $Montant; ?>
                            
                                </tr>
                                <?php
                            }
                                ?>
                        </tbody>
                    </table>
                    
                    <div style="margin-top:30px">
                        <h3> Récapitulatif </h3>
                        <p> Total à payer : <b> <?php echo str_replace('.', ',' , $montantTotal); ?> &euro; <b> </p>
                        <p> <a href="<?php echo site_url("produits/liste"); ?>"> Retour liste des produits </a> </p>
                    </div>
                    <?php
                }
                else
                {
                    ?>
                    <div class="alert alert-danger"> Votre panier est vide. Pour le remplir, vous pouvez consulter <a href="<?php echo site_url("produits/liste"); ?>"> la liste des produits </a>. </div>
                    <?php
                }
                ?>
            </div>    
        </div>
    </body>
</html> 


