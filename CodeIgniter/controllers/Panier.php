<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    /* IMPORTANT!  Le contrôleur est un fichier PHP contenant le code d'une classe (ici classe Panier).
    Comme on peut le voir ci-dessous, la classe Panier hérite de la classe CI_Controller.
    La classe Panier (en UpperCase) doit se trouver dans le fichier Panier.php. Ce fichier est un controlleur et devra être placé 
    dans le répertoire: application/controllers. Par exemple: application/controllers/Panier.php 
    Le nom d'un contrôleur doit commencer par une majuscule: Panier et le nom de fichier du contrôleur également : Panier.php   
    */

    /* Pour pré-charger automatiquement dans chaque méthode tous les assistants et librairies nécessaires pour tout le projet il faut :
    1. Ouvrir le fichier config/autoload.php.
    2. Rechercher la ligne $autoload['libraries'] et remplacer par: $autoload['libraries'] = array('database', 'form_validation', 'session', 'email');
    3. Rechercher la ligne $autoload['helpers'] et remplacer par:   $autoload['helpers'] = array('form', 'url');    
    */

    /* Pour indiquer à notre application quelle est l'url de base (la racine) : 
    1. Ouvrez le fichier config/config.php 
    2. Rechercher la ligne $config['base_url'] = '' 
    3. Renseigner comme valeur l'url de votre projet:  $config['base_url'] = 'http://localhost/CodeIgniter/';
    
    Désormais, on pourra utiliser la fonction site_url() pour écrire un lien.   
    */

    /* Il est possible d'indiquer quel sera le contrôleur et la méthode à exécuter au lancement de l'application (page d'accueil) :
    1. Ouvrez le fichier    config/routes.php 
    2. Recherchez la ligne  $route['default_controller'] = 'welcome'; 
    3. Remplacez la valeur par le contrôleur et la méthode souhaitée comme page d'accueil: $route['default_controller'] = 'produits/acceuil';   
    */

    /* On va enregistrer la date d'ajout et modification d'un produit etc... 
    Pour obtenir la bonne date et heure, il faut configurer la valeur de l'option datetime_zone sur la valeur Europe/Paris.
    Donc, il faut ajouter l'instruction date_default_timezone_set("Europe/Paris"); dans vos scripts avant toute manipulation de dates.   */
    date_default_timezone_set('Europe/Paris');



    class Panier extends CI_Controller 
    {   
        // C'est une méthode qui va permettre d'afficher le contenu du panier
        public function afficherPanier()
        {
            if($this->session->panier)  // Si le panier déjà existe 
            {
                $aPanier = $this->session->panier;    // Dans le tableau $aPanier on récupère le contenu de la variable de session nommée 'panier' 
            
                $aListe['produitsPanier'] = $aPanier;

                /* Chargement des différents vues
                Notez qu'une vue est apellée par son nom de fichier sans l'extension ".php"
                Attention! Les vues doivent être chargées dans l'ordre de leur affichage (ici header > panier > footer) :    */
                $this->load->view('header');
                $this->load->view('panier', $aListe);   
                $this->load->view('footer');
            }
            else
            {

                /* Chargement des différents vues
                Notez qu'une vue est apellée par son nom de fichier sans l'extension ".php"
                Attention! Les vues doivent être chargées dans l'ordre de leur affichage (ici header > panier > footer) :    */
                $this->load->view('header');
                $this->load->view('panier');   
                $this->load->view('footer');
            }
            
        }
        
        

        
        // C'est une méthode qui va permettre d'ajouter des produits au panier
        public function ajouterPanier() 
        {
            // On récupére en une seule fois toutes les données de panier envoyées par le formulaire ('liste.php').
            $data = $this->input->post();  
            
            /* Ici $data est un tableau associatif contenant les données issues du formulaire liste. Variable $data equivaut au tableau $_POST en PHP natif. 
            
            Notez que  $this->input->post("nom_du_champ")  permet de récupérer la valeur d'un seul champ en lui spécifiant en argument la valeur de l'attribut 'name'.

            On peut ajouter une date d'ajout que le formulaire ne contient pas:   $data["pro_d_ajout"] = date("Y-m-d h:i:s");   
            
            On peut aussi transformer une information venant du formulaire:  $data["pro_ref"] = strtoupper($pro_ref)    ici on mets la référence du produit en majuscules    
            
            On peut supprimer un champ inutile avec la fonction PHP unset() avant l'insertion en bdd:  unset($data["champPasEnBase"])    */

            if ($this->session->panier == null)    // Au 1er article ajouté, création du panier car il n'existe pas
            {
                // On créé un tableau pour stocker les informations du produit:  
                $aPanier = array();

                // On ajoute les infos du produit ($data) au tableau du panier ($aPanier) :
                array_push($aPanier, $data);  

                // Pour mettre une variable en session, on utilise la méthode set_userdata() :      
                $this->session->set_userdata("panier", $aPanier);   /* On stocke le panier dans une variable de session nommée 'panier' 

                Ici set_userdata('panier', $aPanier)  est égal à   $_SESSION["panier"] = $aPanier  en PHP natif.
                
                N'obliez pas que la variable superglobale $_SESSION est un tableau associatif comme les variables $_POST et $_GET.
                        
                A retenir: Même si CodeIgniter propose sa propre syntaxe pour gérer les sessions, il reste possible 
                d'utiliser la syntaxe native PHP ($_SESSION et fonctions associées).   */
                
                // Rediriger le navigateur vers la méthode login() du contrôleur Users.php en lui envoyant via url ($_GET) la clé-valeur: 'kw=basket'
                redirect("produits/liste?kw=basket");   
            }
            else   // Le panier déjà existe (on a déjà mis au moins un article)
            {  
                $aPanier = $this->session->panier;  // Dans le tableau $aPanier on récupère le contenu de la variable de session nommée 'panier' 

                $pro_id = $this->input->post('pro_id');  // On récupère la valeur du champ 'ID' en lui spécifiant en argument la valeur de l'attribut name='pro_id'.

                $bSortie = FALSE;

                // On cherche si le produit existe déjà dans le panier:
                foreach ($aPanier as $element) 
                {
                    if ($element['pro_id'] == $pro_id)
                    {
                        $bSortie = TRUE;
                    }
                }

                if ($bSortie)   // Si le produit est déjà dans le panier, l'utilisateur est averti
                { 
                    // Rediriger le navigateur vers la méthode login() du contrôleur Users.php en lui envoyant via url ($_GET) la clé-valeur: 'mw=basket2'
                    redirect("produits/liste?mw=basket2");   
                }
                else    // Sinon, le produit est ajouté dans le panier
                { 
                    array_push($aPanier, $data);
 
                    $this->session->panier = $aPanier;

                    // Rediriger le navigateur vers la méthode login() du contrôleur Users.php en lui envoyant via url ($_GET) la clé-valeur: 'kw=basket'
                    redirect("produits/liste?kw=basket");   
                }
            }
        }

    


        public function modifierQuantite($pro_id)
        {
            $aPanier = $this->session->panier;   // Dans le tableau $aPanier on récupère le contenu de la variable de session nommée 'panier' 

            $aTemp = array(); //création d'un tableau temporaire vide

            // On parcourt le tableau $aPanier produit après produit
            for ($i = 0; $i < count($aPanier); $i++) 
            {
                if ($aPanier[$i]['pro_id'] !== $pro_id)
                {
                    array_push($aTemp, $aPanier[$i]);   // via méthode array_push() on ajoute $aPanier[$i] dans le tableau temporaire $aTemp
                }
                else
                {
                    $aPanier[$i]['pro_qte']++;
                    
                    array_push($aTemp, $aPanier[$i]);   // via méthode array_push() on ajoute $aPanier[$i] dans le tableau temporaire $aTemp
                }
            }

            $aPanier = $aTemp;  // on ajoute le contenu de $aTemp dans le tableau $aPanier
            
            unset($aTemp);   // On supprime le tableau $aTemp avec la fonction PHP unset() 
            
            // Pour mettre une variable en session, on utilise la méthode set_userdata() :      
            $this->session->set_userdata("panier", $aPanier);   /* On stocke le panier dans une variable de session nommée 'panier' 

            Ici set_userdata('panier', $aPanier)  est égal à   $_SESSION["panier"] = $aPanier  en PHP natif.
            
            N'obliez pas que la variable superglobale $_SESSION est un tableau associatif comme les variables $_POST et $_GET.
                    
            A retenir: Même si CodeIgniter propose sa propre syntaxe pour gérer les sessions, il reste possible 
            d'utiliser la syntaxe native PHP ($_SESSION et fonctions associées).   */

            // On réaffiche le panier 
            redirect("panier/afficherPanier");
        }




        public function supprimerProduit($pro_id)
        {
            $aPanier = $this->session->panier;   // Dans le tableau $aPanier on récupère le contenu de la variable de session nommée 'panier' 

            $aTemp = array(); //création d'un tableau temporaire vide $aTemp

            for ($i=0; $i<count($aPanier); $i++)  // on cherche dans le panier les produits à ne pas supprimer
            {
                if ($aPanier[$i]['pro_id'] !== $pro_id)
                {
                    array_push($aTemp, $aPanier[$i]); // ces produits sont ajoutés dans le tableau temporaire $aTemp
                }
            }

            $aPanier = $aTemp;  // on ajoute le contenu de $aTemp dans le tableau $aPanier
            
            unset($aTemp);  // On supprime le tableau temporaire $aTemp avec la fonction PHP unset() 
            
            $this->session->panier = $aPanier; // le panier prend la valeur du tableau temporaire et ne contient donc plus le produit à supprimer

            // On réaffiche le panier 
            redirect("panier/afficherPanier");
        }






        


    }





?>