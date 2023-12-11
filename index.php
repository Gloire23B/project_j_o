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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- Inclusion de jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <!-- Inclusion de Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- Inclusion de Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- Inclusion de SweetAlert pour les alertes stylisées -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- Script JavaScript pour la gestion de la barre de recherche -->
    <script>
        $(document).ready(function () {
            // Fonction pour afficher une alerte
            function afficherAlerte(message, couleur) {
                Swal.fire({
                    text: message,
                    icon: 'info',
                    timer: 5000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    background: couleur
                });
            }

            // Fonction pour gérer la barre de recherche
            function gererRecherche(motCle) {
                if (motCle === 'Admin1234') {
                    // Redirection vers la page gestion.php
                    window.location.href = 'gestion.php';

                } else {
                    // Si le mot clé n'est pas 'Admin1234' ni numérique, affiche simplement une alerte
                    afficherAlerte("La recherche avec le mot clé '" + motCle + "' n'est pas prise en charge", '#007bff');
                }
            }

            // Gestionnaire d'événement pour la soumission du formulaire de recherche
            $('#formRecherche').submit(function (e) {
                e.preventDefault();
                var motCle = $('#motCle').val();
                gererRecherche(motCle);
            });
        });
    </script>

</head>
<body>

    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">J_O</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#" id="navAccueil">Accueil</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="admin/formulaire_membre.php" id="navInscription">Inscription</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="admin/formulaire_connexion.php" id="navConnexion">Connexion</a>
                </li>
                <!-- Ajouter d'autres onglets au besoin -->
            </ul>
            
            <!-- Barre de recherche -->
            <form class="form-inline ml-auto" id="formRecherche">
                <input class="form-control mr-sm-2" type="search" placeholder="Recherche" aria-label="Recherche" id="motCle" required>
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Rechercher</button>
            </form>
        </div>
    </nav>
    <br><br>

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

    <?php include ('footer.php') ?>
</body>
</html>
