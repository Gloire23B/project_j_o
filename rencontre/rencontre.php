<?php
// Inclusion de la configuration de la base de données
include('config.php');

// Fonction pour planifier un match
// Fonction pour planifier un match
function planifierRencontre($lieu, $type, $idEquipeA, $idEquipeB, $dateRencontre) {
    global $pdo;
    $query = $pdo->prepare('INSERT INTO rencontre (lieu, type, id_equipe_a, id_equipe_b, date_rencontre) VALUES (?, ?, ?, ?, ?)');
    $query->execute([$lieu, $type, $idEquipeA, $idEquipeB, $dateRencontre]);
}

// Fonction pour modifier un match
function modifierRencontre($idRencontre, $lieu, $type, $idEquipeA, $idEquipeB, $dateRencontre) {
    global $pdo;
    $query = $pdo->prepare('UPDATE rencontre SET lieu=?, type=?, id_equipe_a=?, id_equipe_b=?, date_rencontre=? WHERE id_rencontre=?');
    $query->execute([$lieu, $type, $idEquipeA, $idEquipeB, $dateRencontre, $idRencontre]);
}

// Fonction pour annuler un match
function annulerRencontre($idRencontre) {
    global $pdo;
    $query = $pdo->prepare('DELETE FROM rencontre WHERE id_rencontre=?');
    $query->execute([$idRencontre]);
}

// Vérifier si la requête est une requête POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si l'action est définie dans la requête POST
    if (isset($_POST['action'])) {
        // Utiliser un switch pour gérer différentes actions
        switch ($_POST['action']) {
            case 'ajouter':
                // Vérifier si les données nécessaires sont définies dans la requête POST
                if (isset($_POST['lieu'], $_POST['type'], $_POST['id_equipe_a'], $_POST['id_equipe_b'], $_POST['date_rencontre'])) {
                    // Appeler la fonction pour ajouter une rencontre
                    planifierRencontre($_POST['lieu'], $_POST['type'], $_POST['id_equipe_a'], $_POST['id_equipe_b'], $_POST['date_rencontre']);
                }
                break;

            case 'modifier':
                // Vérifier si les données nécessaires sont définies dans la requête POST
                if (isset($_POST['id_rencontre'], $_POST['lieu'], $_POST['type'], $_POST['id_equipe_a'], $_POST['id_equipe_b'], $_POST['date_rencontre'])) {
                    // Appeler la fonction pour modifier une rencontre
                    modifierRencontre($_POST['id_rencontre'], $_POST['lieu'], $_POST['type'], $_POST['id_equipe_a'], $_POST['id_equipe_b'], $_POST['date_rencontre']);
                }
                break;

            case 'supprimer':
                // Vérifier si l'identifiant de la rencontre est défini dans la requête POST
                if (isset($_POST['id_rencontre'])) {
                    // Appeler la fonction pour supprimer une rencontre
                    annulerRencontre($_POST['id_rencontre']);
                }
                break;

            default:
                // Gérer d'autres actions si nécessaire
                break;
        }
    }
}

// Récupération de la liste des matches depuis la base de données
$query = "SELECT * FROM rencontre";
$stmt = $pdo->prepare($query);
$stmt->execute();
$matches = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération de la liste des équipes pour le formulaire de planification
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
    <title>Gestion des Matches</title>
    <!-- Inclusion de Bootstrap pour le style -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Gestion des Matches</h1>

        <!-- Formulaire de planification de match -->
        <form method="post">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="lieu">Lieu:</label>
                    <input type="text" class="form-control" name="lieu" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="type">Type:</label>
                    <select class="form-control" name="type" required>
                        <option value="FOOTBALL">Football</option>
                        <option value="BSKETBALL">Bsketball</option>
                        <option value="HANDBALL">Handball</option>
                        <option value="RUGDY">Rugdy</option>
                        <option value="TENNIS">Tennis</option>
                        <option value="VOLLEYBALL">Volleyball</option>
                        <!-- Ajoutez d'autres options en fonction des types de matchs disponibles -->
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="id_equipe_a">Équipe A:</label>
                    <select class="form-control" name="id_equipe_a" required>
                        <?php foreach ($equipes as $equipe): ?>
                            <option value="<?php echo $equipe['id_equipe']; ?>"><?php echo $equipe['nom_equipe']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="id_equipe_b">Équipe B:</label>
                    <select class="form-control" name="id_equipe_b" required>
                        <?php foreach ($equipes as $equipe): ?>
                            <option value="<?php echo $equipe['id_equipe']; ?>"><?php echo $equipe['nom_equipe']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="date_rencontre">Date du match:</label>
                    <input type="datetime-local" class="form-control" name="date_rencontre" required>
                </div>
            </div>
            <button type="submit"  class="btn btn-primary" name="action" value="ajouter">Planifier Match</button>
        </form>

        <!-- Liste des matches existants -->
        <h2 class="mt-4">Liste des Matches</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Lieu</th>
                    <th>Type</th>
                    <th>Équipe A</th>
                    <th>Équipe B</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($matches as $match): ?>
                    <tr>
                        <td><?php echo $match['lieu']; ?></td>
                        <td><?php echo $match['type']; ?></td>
                        <td><?php echo $match['id_equipe_a']; ?></td>
                        <td><?php echo $match['id_equipe_b']; ?></td>
                        <td><?php echo $match['date_rencontre']; ?></td>
                        <td>
                            <a href="modifier_rencontre.php?id=<?php echo $match['id_rencontre']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="rencontre.php" onclick="annulerRencontre(<?php echo $match['id_rencontre']; ?>)" class="btn btn-danger btn-sm">Annuler</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Script JavaScript pour l'annulation asynchrone d'un match -->
    <script>
        function annulerRencontre(id_rencontre) {
            if (confirm("Êtes-vous sûr de vouloir annuler ce match?")) {
                // Envoi de la requête AJAX pour annuler le match
                let formData = new FormData();
                formData.append('action', 'supprimer');
                formData.append('id_rencontre', id_rencontre);

                fetch('rencontre.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        location.reload(); // Recharger la page après l'annulation
                    } else {
                        console.error('Erreur lors de l\'annulation du match');
                    }
                })
                .catch(error => console.error('Erreur:', error));
            }
        }
    </script>

</body>
</html>
