<?php
// Inclusion de la configuration de la base de données
include('config.php');

// Vérifie si la requête de recherche a été soumise
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des critères de recherche depuis le formulaire
    $critere = isset($_POST['critere']) ? $_POST['critere'] : '';
    $valeur = isset($_POST['valeur']) ? $_POST['valeur'] : '';

    // Requête SQL pour la recherche basée sur le critère et la valeur
    $query = "SELECT * FROM personnel WHERE $critere LIKE :valeur";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':valeur', "%$valeur%", PDO::PARAM_STR);
    $stmt->execute();
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche</title>
    <!-- Inclusion de Bootstrap pour le style -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text_center">Recherche</h1>
        <p class><a href="../gestion.php">Home</a></p>
        <br><br>

        <!-- Formulaire de recherche -->
        <form method="post" class="form-inline mt-3">
            <label class="mr-2">Critère de recherche:</label>
            <select class="form-control mr-2" name="critere">
                <option value="prenom">Prénom</option>
                <option value="nom">Nom</option>
                <option value="sexe">Sexe</option>
                <option value="role">Rôle</option>
                <!-- Ajoutez d'autres options selon les critères disponibles -->
            </select>
            <label class="mr-2">Valeur:</label>
            <input type="text" class="form-control mr-2" name="valeur" required>
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </form>

        <!-- Affichage des résultats de la recherche -->
        <?php if (isset($resultats)): ?>
            <h2 class="mt-4">Résultats de la Recherche</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Sexe</th>
                        <th>Rôle</th>
                        <th>Équipe</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultats as $resultat): ?>
                        <tr>
                            <td><?php echo $resultat['prenom']; ?></td>
                            <td><?php echo $resultat['nom']; ?></td>
                            <td><?php echo $resultat['sexe']; ?></td>
                            <td><?php echo $resultat['role']; ?></td>
                            <td><?php echo $resultat['id_equipe']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
