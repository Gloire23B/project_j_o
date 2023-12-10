<?php
// Inclusion de la configuration de la base de données
include('config.php');

// Fonction pour ajouter un membre du personnel
function ajouterPersonnel($prenom, $nom, $sexe, $role, $id_equipe) {
    global $pdo;
    $query = "INSERT INTO personnel (prenom, nom, sexe, role, id_equipe) VALUES (:prenom, :nom, :sexe, :role, :id_equipe)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':sexe', $sexe);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':id_equipe', $id_equipe);
    return $stmt->execute();
}

// Fonction pour modifier les détails d'un membre du personnel
function modifierPersonnel($id_personnel, $prenom, $nom, $sexe, $role, $id_equipe) {
    global $pdo;
    $query = "UPDATE personnel SET prenom = :prenom, nom = :nom, sexe = :sexe, role = :role, id_equipe = :id_equipe WHERE id_personnel = :id_personnel";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_personnel', $id_personnel);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':sexe', $sexe);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':id_equipe', $id_equipe);
    return $stmt->execute();
}

// Fonction pour supprimer un membre du personnel
function supprimerPersonnel($id_personnel) {
    global $pdo;
    $query = "DELETE FROM personnel WHERE id_personnel = :id_personnel";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_personnel', $id_personnel);
    return $stmt->execute();
}

// Exécution des actions CRUD en fonction de la requête reçue
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'ajouter':
                if (isset($_POST['prenom'], $_POST['nom'], $_POST['sexe'], $_POST['role'], $_POST['id_equipe'])) {
                    ajouterPersonnel($_POST['prenom'], $_POST['nom'], $_POST['sexe'], $_POST['role'], $_POST['id_equipe']);
                }
                break;

            case 'modifier':
                if (isset($_POST['id_personnel'], $_POST['prenom'], $_POST['nom'], $_POST['sexe'], $_POST['role'], $_POST['id_equipe'])) {
                    modifierPersonnel($_POST['id_personnel'], $_POST['prenom'], $_POST['nom'], $_POST['sexe'], $_POST['role'], $_POST['id_equipe']);
                }
                break;

            case 'supprimer':
                if (isset($_POST['id_personnel'])) {
                    supprimerPersonnel($_POST['id_personnel']);
                }
                break;

            default:
                // Gérer d'autres actions si nécessaire
                break;
        }
    }
}

// Récupération de la liste du personnel depuis la base de données
$query = "SELECT * FROM personnel";
$stmt = $pdo->prepare($query);
$stmt->execute();
$personnel = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Gestion du Personnel</title>
</head>
<body>
    <h1>Gestion du Personnel</h1>

    <!-- Formulaire d'ajout de personnel -->
    <form method="post">
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="prenom">Prénom:</label>
                <input type="text" class="form-control" name="prenom" required>
            </div>
            <div class="form-group col-md-3">
                <label for="nom">Nom:</label>
                <input type="text" class="form-control" name="nom" required>
            </div>
            <div class="form-group col-md-2">
                <label for="sexe">Sexe:</label>
                <select class="form-control" name="sexe" required>
                    <option value="homme">Homme</option>
                    <option value="femme">Femme</option>
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="role">Rôle:</label>
                <input type="text" class="form-control" name="role" required>
            </div>
            <div class="form-group col-md-2">
            <label for="id_equipe">Équipe:</label>
                <select class="form-control" name="id_equipe" required>
                    <!-- Récupérez la liste des équipes depuis la base de données -->
                    <?php
                    $query = "SELECT * FROM equipe";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $equipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($equipes as $equipe) {
                        echo "<option value=\"{$equipe['id_equipe']}\">{$equipe['nom_equipe']}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary" name="action" value="ajouter">Ajouter Personnel</button>
    </form>

    <!-- Liste du personnel existant -->
    <h2 class="mt-4">Liste du Personnel</h2>
    <table class="table">
        <tr>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Sexe</th>
            <th>Rôle</th>
            <th>Équipe</th>
            <th>Action</th>
        </tr>
        <?php foreach ($personnel as $individu): ?>
            <tr>
                <td><?php echo $individu['prenom']; ?></td>
                <td><?php echo $individu['nom']; ?></td>
                <td><?php echo $individu['sexe']; ?></td>
                <td><?php echo $individu['role']; ?></td>
                <td><?php echo $individu['id_equipe']; ?></td>
                <td>
                    <!-- Liens pour modifier et supprimer chaque membre du personnel -->
                    <a href="modifier_personnel.php?id=<?php echo $individu['id_personnel']; ?>">Modifier</a>
                    <a href="personnel.php" onclick="supprimerPersonnel(<?php echo $individu['id_personnel']; ?>)">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>

    <!-- Script JavaScript pour la suppression asynchrone du personnel -->
    <script>
        function supprimerPersonnel(id_personnel) {
            if (confirm("Êtes-vous sûr de vouloir supprimer ce membre du personnel?")) {
                // Envoi de la requête AJAX pour supprimer le membre du personnel
                let formData = new FormData();
                formData.append('action', 'supprimer');
                formData.append('id_personnel', id_personnel);

                fetch('personnel.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        location.reload(); // Recharger la page après la suppression
                    } else {
                        console.error('Erreur lors de la suppression du membre du personnel');
                    }
                })
                .catch(error => console.error('Erreur:', error));
            }
        }
    </script>
</body>
</html>
