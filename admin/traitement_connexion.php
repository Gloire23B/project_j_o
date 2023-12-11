<?php
try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=23_24_b2_jeux_olympiques", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération des données du formulaire
    $login = $_POST['login'];
    $mdp = $_POST['mdp'];

    // Vérification des identifiants
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE login = :login");
    $stmt->bindParam(':login', $login, PDO::PARAM_STR);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($mdp, $admin['mdp'])) {
        // Enregistrement des informations de l'utilisateur dans la session
        $_SESSION['id'] = $admin['id'];
        $_SESSION['login'] = $admin['login'];

        // Redirection vers la page appropriée
        if ($admin['login'] === 'gloire') {
            header("Location: ../gestion.php");
        } else {
            header("Location: ../index0.php");
        }
        exit();
    } else {
        echo "<p class='text-danger'>Login ou mot de passe incorrect.</p>";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
