<?php
// Inclusion de la configuration de la base de données
include('config/config.php');

// Récupération des rencontres à venir
$queryRencontresAVenir = "SELECT * FROM rencontre WHERE date_rencontre > NOW() ORDER BY date_rencontre ASC";
$stmtRencontresAVenir = $pdo->prepare($queryRencontresAVenir);
$stmtRencontresAVenir->execute();
$rencontresAVenir = $stmtRencontresAVenir->fetchAll(PDO::FETCH_ASSOC);

$queryResultats = "SELECT * FROM resultat_match INNER JOIN rencontre ON resultat_match.id_rencontre = rencontre.id_rencontre WHERE rencontre.date_rencontre < NOW() ORDER BY date_rencontre ASC";
$stmtResultats = $pdo->prepare($queryResultats);
$stmtResultats->execute();
$resultats = $stmtResultats->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <!-- Inclusion de Bootstrap pour le style -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Rencontres à Venir</h1>

        <!-- Affichage des rencontres à venir sous forme de cartes (Cards) -->
        <div class="card-deck mt-4">
            <?php foreach ($rencontresAVenir as $rencontre): ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $rencontre['lieu']; ?></h5>
                        <p class="card-text"><?php echo $rencontre['type']; ?></p>
                        <p class="card-text">Équipe A: <?php echo $rencontre['id_equipe_a']; ?></p>
                        <p class="card-text">Équipe B: <?php echo $rencontre['id_equipe_b']; ?></p>
                        <p class="card-text">Date: <?php echo $rencontre['date_rencontre']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <br><br>

    <div class="container mt-5">
        <h1>Résultats des Rencontres Passées</h1>

        <!-- Affichage des résultats des rencontres passées sous forme de cartes (Cards) -->
        <div class="card-deck mt-4">
            <?php foreach ($resultats as $resultat): ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $resultat['lieu']; ?></h5>
                        <p class="card-text"><?php echo $resultat['type']; ?></p>
                        <p class="card-text">Équipe A: <?php echo $resultat['id_equipe_a']; ?></p>
                        <p class="card-text">Équipe B: <?php echo $resultat['id_equipe_b']; ?></p>
                        <p class="card-text">Date de la Rencontre: <?php echo $resultat['date_rencontre']; ?></p>
                        <p class="card-text">Résultat: Équipe A <?php echo $resultat['score_equipe_a']; ?> - <?php echo $resultat['score_equipe_b']; ?> Équipe B</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Inclusion de Bootstrap JS pour les fonctionnalités avancées (facultatif) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
