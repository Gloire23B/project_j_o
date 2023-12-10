<?php
// Inclusion de la configuration de la base de données
include('config.php');

// Vérifie si un ID de personnel est passé en paramètre
if (isset($_GET['id'])) {
    $id_personnel = $_GET['id'];

    // Récupération des détails du membre du personnel à modifier depuis la base de données
    $query = "SELECT * FROM personnel WHERE id_personnel = :id_personnel";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_personnel', $id_personnel);
    $stmt->execute();
    $individu = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifie si le membre du personnel existe
    if (!$individu) {
        die('Membre du personnel non trouvé.');
    }
} else {
    die('ID de membre du personnel non spécifié.');
}

// Traitement de la modification si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['modifier_personnel'])) {
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $sexe = $_POST['sexe'];
        $role = $_POST['role'];
        $id_equipe = $_POST['id_equipe'];

        // Mise à jour des détails du membre du personnel dans la base de données
        $query = "UPDATE personnel SET prenom = :prenom, nom = :nom, sexe = :sexe, role = :role, id_equipe = :id_equipe WHERE id_personnel = :id_personnel";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_personnel', $id_personnel);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':sexe', $sexe);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id_equipe', $id_equipe);

        if ($stmt->execute()) {
            header('Location: personnel.php'); // Redirection vers la page de gestion du personnel
            exit();
        } else {
            die('Erreur lors de la mise à jour du membre du personnel.');
        }
    }
}

// Récupération de la liste des équipes pour le formulaire de modification
$queryEquipes = "SELECT * FROM equipe";
$stmtEquipes = $pdo->prepare($queryEquipes);
$stmtEquipes->execute();
$equipes = $stmtEquipes->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Membre du Personnel</title>
    <!-- Inclusion de Bootstrap pour le style -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Modifier Membre du Personnel</h1>

        <!-- Formulaire de modification de personnel -->
        <form method="post">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="prenom">Prénom:</label>
                    <input type="text" class="form-control" name="prenom" value="<?php echo $individu['prenom']; ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="nom">Nom:</label>
                    <input type="text" class="form-control" name="nom" value="<?php echo $individu['nom']; ?>" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="sexe">Sexe:</label>
                    <select class="form-control" name="sexe" required>
                        <option value="homme" <?php echo ($individu['sexe'] === 'homme') ? 'selected' : ''; ?>>Homme</option>
                        <option value="femme" <?php echo ($individu['sexe'] === 'femme') ? 'selected' : ''; ?>>Femme</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="role">Rôle:</label>
                    <input type="text" class="form-control" name="role" value="<?php echo $individu['role']; ?>" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="id_equipe">Équipe:</label>
                    <select class="form-control" name="id_equipe" required>
                        <?php foreach ($equipes as $equipe): ?>
                            <option value="<?php echo $equipe['id_equipe']; ?>" <?php echo ($individu['id_equipe'] == $equipe['id_equipe']) ? 'selected' : ''; ?>>
                                <?php echo $equipe['nom_equipe']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" name="modifier_personnel">Modifier Membre du Personnel</button>
        </form>

        <p><a href="personnel.php">Retour à la liste du personnel</a></p>
    </div>
</body>
</html>
