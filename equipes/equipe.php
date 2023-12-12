<?php
// Inclusion de la configuration de la base de données
include('config.php');

// Fonction pour ajouter une nouvelle équipe
function ajouterEquipe($nom_equipe) {
    global $pdo;
    $query = "INSERT INTO equipe (nom_equipe) VALUES (:nom_equipe)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nom_equipe', $nom_equipe);
    return $stmt->execute();
}

// Fonction pour modifier les détails d'une équipe
function modifierEquipe($id_equipe, $nom_equipe) {
    global $pdo;
    $query = "UPDATE equipe SET nom_equipe = :nom_equipe WHERE id_equipe = :id_equipe";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_equipe', $id_equipe);
    $stmt->bindParam(':nom_equipe', $nom_equipe);
    return $stmt->execute();
}

// Fonction pour supprimer une équipe
function supprimerEquipe($id_equipe) {
    global $pdo;
    $query = "DELETE FROM equipe WHERE id_equipe = :id_equipe";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_equipe', $id_equipe);
    return $stmt->execute();
}

// Exécution des actions CRUD en fonction de la requête reçue
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'ajouter':
                if (isset($_POST['nom_equipe'])) {
                    ajouterEquipe($_POST['nom_equipe']);
                }
                break;

            case 'modifier':
                if (isset($_POST['id_equipe']) && isset($_POST['nom_equipe'])) {
                    modifierEquipe($_POST['id_equipe'], $_POST['nom_equipe']);
                }
                break;

            case 'supprimer':
                if (isset($_POST['id_equipe'])) {
                    supprimerEquipe($_POST['id_equipe']);
                }
                break;

            default:
                // Gérer d'autres actions si nécessaire
                break;
        }
    }
}

// Récupération de la liste des équipes depuis la base de données
$query = "SELECT * FROM equipe";
$stmt = $pdo->prepare($query);
$stmt->execute();
$equipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['filter'])) {
    $matchFilter = $_POST['matchFilter'];
    if ($matchFilter == 'withMatch') {
        $query = "SELECT DISTINCT equipe.* FROM equipe 
                  JOIN rencontre ON equipe.id_equipe = rencontre.id_equipe_a OR equipe.id_equipe = rencontre.id_equipe_b 
                  WHERE date_rencontre > NOW()";
    } elseif ($matchFilter == 'withoutMatch') {
        $query = "SELECT * FROM equipe 
                  WHERE id_equipe NOT IN (
                      SELECT DISTINCT id_equipe_a FROM rencontre WHERE date_rencontre > NOW()
                  ) 
                  AND id_equipe NOT IN (
                      SELECT DISTINCT id_equipe_b FROM rencontre WHERE date_rencontre > NOW()
                  )";
    } else {
        $query = "SELECT * FROM equipe";
    }

    $requete = $pdo->prepare($query);
    $requete->execute();
    $equipes = $requete->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Gestion des Équipes</title>
</head>
<body>
    <h1 class="text-center">Gestion des Équipes</h1>
    <p class="text-center"><a href="../gestion.php">Home</a></p>

    <!-- Formulaire d'ajout d'équipe -->
    <form method="post" class="text-center">
        <div class="form-group"></div>
            <label for="nom_equipe"><h2>Nom de l'équipe: </h2></label>
            <input type="text" name="nom_equipe" class="form-text" id="nom_equipe" required>
        </div>
        <button type="submit" name="action" class="btn btn-success" value="ajouter">Ajouter Équipe</button>
    </form>
    <br><br>
    
    <!-- Liste des équipes existantes -->
    <main class="container mt-3 text-center">
        <form method="post" action="" class="mt-3 mb-3">
            <label for="matchFilter">Filtre :</label>
            <select name="matchFilter" id="matchFilter">
                <option value="all">Tous</option>
                <option value="withMatch">Équipes avec des matchs à venir</option>
                <option value="withoutMatch">Équipes sans match à venir</option>
            </select>
            <input type="submit" name="filter" value="Filtrer">
        </form>
        <br><br>

        <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Nom de L'équipe</th>
                    <th>Action</th>
                </tr>

                <?php foreach ($equipes as $equipe): ?>
                    <tr>
                        <td><?php echo $equipe['id_equipe']; ?></td>
                        <td><?php echo $equipe['nom_equipe']; ?></td>

                        <td>
                            <!-- Liens pour modifier et supprimer chaque équipe -->
                            <a href="modifier_equipe.php?id=<?php echo $equipe['id_equipe']; ?>" class="btn btn-primary">Modifier</a>
                            <a href="#" onclick="supprimerEquipe(<?php echo $equipe['id_equipe']; ?>)" class="btn btn-danger">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
        </table>
    </main>
    <!-- Script JavaScript pour la suppression asynchrone des équipes -->
    <script>
        function supprimerEquipe(id_equipe) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cette équipe?")) {
                // Envoi de la requête AJAX pour supprimer l'équipe
                let formData = new FormData();
                formData.append('action', 'supprimer');
                formData.append('id_equipe', id_equipe);

                fetch('equipe.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        location.reload(); // Recharger la page après la suppression
                    } else {
                        console.error('Erreur lors de la suppression de l\'équipe');
                    }
                })
                .catch(error => console.error('Erreur:', error));
            }
        }
    </script>
</body>
</html>
