<?php

// Inclusion du fichier s'occupant de la connexion à la DB (TODO)
require __DIR__.'/inc/db.php'; // Pour __DIR__ => http://php.net/manual/fr/language.constants.predefined.php
// Rappel : la variable $pdo est disponible dans ce fichier
//          car elle a été créée par le fichier inclus ci-dessus

// Initialisation de variables (évite les "NOTICE - variable inexistante")
$videogameList = array();
$platformList = array();
$name = '';
$editor = '';
$release_date = '';
$platform = '';

// Si le formulaire a été soumis
if (!empty($_POST)) {
    // Récupération des valeurs du formulaire dans des variables
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $editor = isset($_POST['editor']) ? $_POST['editor'] : '';
    $release_date = isset($_POST['release_date']) ? $_POST['release_date'] : '';
    $platform = isset($_POST['platform']) ? intval($_POST['platform']) : 0;
    
    // TODO #3 (optionnel) valider les données reçues (ex: donnée non vide)
    // --- START OF YOUR CODE ---


    // Par défaut je pars du principe qu'il n'y a pas d'erreur
    $has_errors = false;
    // Donc une liste de messages d'erreur vide
    $messages = [];
    // Je vérifie ensuite que chacun de mes champs est bien renseigné
    // par l'utilisateur. Si ça n'est pas le cas, je change ma variable
    // has_errors pour indiquer qu'il y a un problème
    // et j'ajoute à mon array de messages une indication pour l'user
    if(empty($name)){
        $has_errors = true;
        $messages[] = "Merci de renseigner un nom";
    }

    if(empty($editor)){
        $has_errors = true;
        $messages[] = "Merci de renseigner un éditeur";
    }

    if(empty($release_date)){
        $has_errors = true;
        $messages[] = "Merci de renseigner une date au format YYYY/MM/DD";
    }

    if(empty($platform)){
        $has_errors = true;
        $messages[] = "Merci de renseigner la plateforme de sortie";
    }

    // Si le contenu de has_errors est true (si j'ai une ou des erreurs)
    if($has_errors === true) {

        echo 'Vous avez oublié un truc on dirait chenapan...'.'<br/>';
        
        // Je parcours mon tableau de messages,
        // et j'affiche chacun d'eux.
        
        foreach($messages as $message){
            echo $message.'<br/>';
        }
    }



    // --- END OF YOUR CODE ---
    
    // Insertion en DB du jeu video
    $insertQuery = "
        INSERT INTO videogame (name, editor, release_date, platform_id)
        VALUES ('{$name}', '{$editor}', '{$release_date}', {$platform})
    ";

    // TODO #3 exécuter la requête qui insère les données
    // Je stocke dans une variable le nombre de lignes
    // (de données) affectées par ma requete. Ici j'ajoute UN jeu video
    // Donc en cas de succès,je m'attend à avoir 1 ligne impactée

    if($has_errors === false) {
        $nombreDeResultatsAffectés = $pdo->exec($insertQuery);
        // TODO #3 une fois inséré, faire une redirection vers la page "index.php" (fonction header)
        header('Location: ./index.php');
        echo 'On a modifié ' .$nombreDeResultatsAffectés. ' ligne(s) dans la BDD';
    }
    


    // --- END OF YOUR CODE ---
}

// Liste des consoles de jeux
// TODO #4 (optionnel) récupérer cette liste depuis la base de données
// --- START OF YOUR CODE ---
// $platformList = array(
//     1 => [
//         "id"= "",
//         "name"= "kldlkj"
//     ],
//     2 => 'MegaDrive',
//     3 => 'SNES',
//     4 => 'PlayStation'
// );

$requeteSQL = '
    SELECT * FROM platform
';

 $monStatement = $pdo->query($requeteSQL);

 $platformList = $monStatement->fetchAll(PDO::FETCH_ASSOC);

echo '<pre>';
var_dump($platformList);
echo '</pre>';

// --- END OF YOUR CODE ---

// TODO #1 écrire la requête SQL permettant de récupérer les jeux vidéos en base de données (mais ne pas l'exécuter maintenant)
// --- START OF YOUR CODE ---
$sql = '
    SELECT * FROM videogame
';
// --- END OF YOUR CODE ---

// Si un tri a été demandé, on réécrit la requête
if (!empty($_GET['order'])) {
    // Récupération du tri choisi
    $order = trim($_GET['order']);
    if ($order == 'name') {
        // TODO #2 écrire la requête avec un tri par nom croissant
        // --- START OF YOUR CODE ---
        $sql .= ' 
            ORDER BY name ASC
        ';
        // --- END OF YOUR CODE ---
    }
    else if ($order == 'editor') {
        // TODO #2 écrire la requête avec un tri par editeur croissant
        // --- START OF YOUR CODE ---
        $sql .= ' 
            ORDER BY editor ASC
        ';
        // --- END OF YOUR CODE ---
    }
}
// TODO #1 exécuter la requête contenue dans $sql et récupérer les valeurs dans la variable $videogameList
// --- START OF YOUR CODE ---

// Premièrement, j'utilise pdo pour obtenir un pdostatement

$monPDOStatement = $pdo->query($sql);

if ($monPDOStatement === false) {
    echo 'Il y a eu un ptit problème, oups....';
    die();
}

// Si j'arrive jusqu'ici, c'est que pas d'erreur
// Je peux donc essayer de récupérer la liste

$videogameList = $monPDOStatement->fetchAll(PDO::FETCH_ASSOC);

// echo '<pre>';
// var_dump($videogameList);
// echo '</pre>';


// --- END OF YOUR CODE ---

// Inclusion du fichier s'occupant d'afficher le code HTML
// Je fais cela car mon fichier actuel est déjà assez gros, donc autant le faire ailleurs (pas le métier hein ! ;) )
require __DIR__.'/view/videogame.php';
