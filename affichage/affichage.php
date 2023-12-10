<?php
// Inclusion de la configuration de la base de données
include('config.php');

// Récupération de la liste des équipes
$queryEquipes = "SELECT * FROM equipe";
$stmtEquipes = $pdo->prepare($queryEquipes);
$stmtEquipes->execute();
$equipes = $stmtEquipes->fetchAll(PDO::FETCH_ASSOC);

// Récupération de la liste du personnel
$queryPersonnel = "SELECT * FROM personnel";
$stmtPersonnel = $pdo->prepare($queryPersonnel);
$stmtPersonnel->execute();
$personnel = $stmtPersonnel->fetchAll(PDO::FETCH_ASSOC);

// Récupération de la liste des matchs planifiés
$queryRencontres = "SELECT * FROM rencontre";
$stmtRencontres = $pdo->prepare($queryRencontres);
$stmtRencontres->execute();
$rencontres = $stmtRencontres->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage des Informations</title>
    <!-- Inclusion de Bootstrap pour le style -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Affichage des Informations</h1>

        <!-- Liste des équipes -->
        <h2 class="mt-4">Liste des Équipes</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Liste des Équipes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($equipes as $equipe): ?>
                    <tr>
                        <td><?php echo $equipe['id_equipe']; ?></td>
                        <td><?php echo $equipe['nom_equipe']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br><br>

        <!-- Liste du personnel -->
        <h2 class="mt-4">Liste du Personnel</h2>
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
                <?php foreach ($personnel as $membre): ?>
                    <tr>
                        <td><?php echo $membre['prenom']; ?></td>
                        <td><?php echo $membre['nom']; ?></td>
                        <td><?php echo $membre['sexe']; ?></td>
                        <td><?php echo $membre['role']; ?></td>
                        <td><?php echo $membre['id_equipe']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br><br>

        <!-- Liste des matchs planifiés -->
        <h2 class="mt-4">Liste des Matchs Planifiés</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Lieu</th>
                    <th>Type</th>
                    <th>Équipe A</th>
                    <th>Équipe B</th>
                    <th>Date de la Rencontre</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rencontres as $rencontre): ?>
                    <tr>
                        <td><?php echo $rencontre['lieu']; ?></td>
                        <td><?php echo $rencontre['type']; ?></td>
                        <td><?php echo $rencontre['id_equipe_a']; ?></td>
                        <td><?php echo $rencontre['id_equipe_b']; ?></td>
                        <td><?php echo $rencontre['date_rencontre']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
