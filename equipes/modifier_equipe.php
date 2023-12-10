<?php
// Inclusion de la configuration de la base de données
include('config.php');

// Vérifie si un ID d'équipe est passé en paramètre
if (isset($_GET['id'])) {
    $id_equipe = $_GET['id'];

    // Récupération des détails de l'équipe à modifier depuis la base de données
    $query = "SELECT * FROM equipe WHERE id_equipe = :id_equipe";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_equipe', $id_equipe);
    $stmt->execute();
    $equipe = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifie si l'équipe existe
    if (!$equipe) {
        die('Équipe non trouvée.');
    }
} else {
    die('ID d\'équipe non spécifié.');
}

// Traitement de la modification si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['modifier_equipe'])) {
        $nom_equipe = $_POST['nom_equipe'];

        // Mise à jour des détails de l'équipe dans la base de données
        $query = "UPDATE equipe SET nom_equipe = :nom_equipe WHERE id_equipe = :id_equipe";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_equipe', $id_equipe);
        $stmt->bindParam(':nom_equipe', $nom_equipe);

        if ($stmt->execute()) {
            header('Location: equipe.php'); // Redirection vers la page de gestion des équipes
            exit();
        } else {
            die('Erreur lors de la mise à jour de l\'équipe.');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Modifier Équipe</title>
</head>
<body>
    <h1>Modifier Équipe</h1>

    <!-- Formulaire de modification d'équipe -->
    <form method="post">
        <label for="nom_equipe">Nom de l'équipe:</label>
        <input type="text" name="nom_equipe" class="form-text" value="<?php echo $equipe['nom_equipe']; ?>" required>
        <button type="submit" name="modifier_equipe" class="btn btn-primary">Modifier Équipe</button>
    </form>

    <p><a href="equipe.php">Retour à la liste des équipes</a></p>
</body>
</html>
