<?php

// TODO #1 créer un objet PDO permettant de se connecter à la base de données "videogame"
// et le stocker dans la variable $pdo
// --- START OF YOUR CODE ---


// Premierement, j'ai besoin des infos pour me cnnecter à la BDD

$dsn = "mysql:dbname=videogame;host=localhost;charset=utf8";
$user="videogame";
$password="videogame";

// IL est également possible de donner des options supplémentaires
// à PDO. Ici nous allons lui en donner une pour recevoir côté php
// les erreurs éventuellement envoyées par mysql

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
];

$pdo = new PDO($dsn, $user, $password, $options);


// --- END OF YOUR CODE ---
