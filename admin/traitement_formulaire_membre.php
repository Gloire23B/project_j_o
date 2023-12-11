<?php
include ('config/config.php');

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assurez-vous que tous les champs obligatoires sont remplis
    if (!empty($_POST['login']) && !empty($_POST['mdp'])) {

        // Récupérer les données du formulaire
        $login = $_POST['login'];
        $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT); // Hashage du mot de passe

        // Insertion des données dans la table membre (assurez-vous d'utiliser des requêtes préparées)
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=23_24_b2_jeux_olympiques", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("INSERT INTO admin (login, mdp) VALUES (?, ?)");
        $stmt->execute([$login, $mdp]);

        header("Location: formulaire_membre.php");
        exit();
    } else {
        $erreur_message = "Remplir tous les champs pour créer un compte.";
        include('formulaire_membre.php');
    }
}
?>
