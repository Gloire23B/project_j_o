<?php
// Inclusion de la configuration de la base de données
include('config/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion</title>
    <!-- Inclusion de Bootstrap pour le style -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Gestion</h1>

        <!-- Affichage des fonctionnalités sous forme de cartes (Cards) -->
        <div class="card-deck mt-4">
            <!-- Gestion des Équipes -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Gestion des Équipes</h5>
                    <p class="card-text">Ajouter, modifier, supprimer des équipes.</p>
                    <a href="equipes/equipe.php" class="btn btn-primary">Accéder à la Gestion des Équipes</a>
                </div>
            </div>

            <!-- Gestion du Personnel -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Gestion du Personnel</h5>
                    <p class="card-text">Ajouter, modifier, supprimer des membres du personnel.</p>
                    <a href="personnel/personnel.php" class="btn btn-primary">Accéder à la Gestion du Personnel</a>
                </div>
            </div>

            <!-- Gestion des Matchs -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Gestion des Matchs</h5>
                    <p class="card-text">Planifier, modifier, annuler des matchs.</p>
                    <a href="rencontre/rencontre.php" class="btn btn-primary">Accéder à la Gestion des Matchs</a>
                </div>
            </div>

            <!-- Gestion des Matchs -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Recherche de Personnel</h5>
                    <p class="card-text">Rechercher rapidement un membre du personnel en fonction d'un critère.</p>
                    <a href="recherche/recherche.php" class="btn btn-primary">Accéder à la Recherche rapide</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Inclusion de Bootstrap JS pour les fonctionnalités avancées (facultatif) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
