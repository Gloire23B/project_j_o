<?php
// Inclusion de la configuration de la base de données
include('config.php');

// Vérifie si un ID de rencontre est passé en paramètre
if (isset($_GET['id'])) {
    $id_rencontre = $_GET['id'];

    // Récupération des détails de la rencontre à modifier depuis la base de données
    $query = "SELECT * FROM rencontre WHERE id_rencontre = :id_rencontre";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_rencontre', $id_rencontre);
    $stmt->execute();
    $match = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifie si la rencontre existe
    if (!$match) {
        die('Rencontre non trouvée.');
    }
} else {
    die('ID de rencontre non spécifié.');
}

// Traitement de la modification si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['modifier_rencontre'])) {
        $lieu = $_POST['lieu'];
        $type = $_POST['type'];
        $id_equipe_a = $_POST['id_equipe_a'];
        $id_equipe_b = $_POST['id_equipe_b'];
        $date_rencontre = $_POST['date_rencontre'];

        // Mise à jour des détails de la rencontre dans la base de données
        $query = "UPDATE rencontre SET lieu = :lieu, type = :type, id_equipe_a = :id_equipe_a, id_equipe_b = :id_equipe_b, date_rencontre = :date_rencontre WHERE id_rencontre = :id_rencontre";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_rencontre', $id_rencontre);
        $stmt->bindParam(':lieu', $lieu);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':id_equipe_a', $id_equipe_a);
        $stmt->bindParam(':id_equipe_b', $id_equipe_b);
        $stmt->bindParam(':date_rencontre', $date_rencontre);

        if ($stmt->execute()) {
            header('Location: rencontre.php'); // Redirection vers la page de gestion des rencontres
            exit();
        } else {
            die('Erreur lors de la mise à jour de la rencontre.');
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
    <title>Modifier Rencontre</title>
    <!-- Inclusion de Bootstrap pour le style -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Modifier Rencontre</h1>

        <!-- Formulaire de modification de rencontre -->
        <form method="post">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="lieu">Lieu:</label>
                    <input type="text" class="form-control" name="lieu" value="<?php echo $match['lieu']; ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="type">Type:</label>
                    <input type="text" class="form-control" name="type" value="<?php echo $match['type']; ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="id_equipe_a">Équipe A:</label>
                    <select class="form-control" name="id_equipe_a" required>
                        <?php foreach ($equipes as $equipe): ?>
                            <option value="<?php echo $equipe['id_equipe']; ?>" <?php echo ($match['id_equipe_a'] == $equipe['id_equipe']) ? 'selected' : ''; ?>>
                                <?php echo $equipe['nom_equipe']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="id_equipe_b">Équipe B:</label>
                    <select class="form-control" name="id_equipe_b" required>
                        <?php foreach ($equipes as $equipe): ?>
                            <option value="<?php echo $equipe['id_equipe']; ?>" <?php echo ($match['id_equipe_b'] == $equipe['id_equipe']) ? 'selected' : ''; ?>>
                                <?php echo $equipe['nom_equipe']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="date_rencontre">Date Rencontre:</label>
                    <input type="datetime-local" class="form-control" name="date_rencontre" value="<?php echo date('Y-m-d\TH:i', strtotime($match['date_rencontre'])); ?>" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" name="modifier_rencontre">Modifier Rencontre</button>
        </form>

        <p><a href="rencontre.php">Retour à la liste des rencontres</a></p>
    </div>
</body>
</html>
