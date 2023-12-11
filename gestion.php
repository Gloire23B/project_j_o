<?php
session_start();
// Inclusion de la configuration de la base de données
include('config/config.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id']) || $_SESSION['login'] !== 'gloire') {
    header("Location: admin/formulaire_connexion.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion</title>
    <!-- Inclusion de Bootstrap pour le style -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- Inclusion de SweetAlert pour les alertes stylisées -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


    <!-- Inclusion de jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <!-- Inclusion de Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>


    <!-- Script JavaScript pour la gestion de la barre de recherche -->

    <script>
        $(document).ready(function () {
            // Fonction pour afficher une alerte
            function afficherAlerte(message, couleur) {
                Swal.fire({
                    text: message,
                    icon: 'info',
                    timer: 15000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    background: couleur
                });
            }

            // Fonction pour gérer la barre de recherche
            function gererRecherche(motCle) {
                <?php
                // Inclusion de la configuration de la base de données
                include('config/config.php');

                // Fonction pour rechercher le personnel par le prénom
                function rechercherPersonnel($prenom) {
                    global $pdo;
                    $query = "SELECT * FROM personnel WHERE prenom LIKE :prenom";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindValue(':prenom', '%' . $prenom . '%', PDO::PARAM_STR);
                    $stmt->execute();
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                ?>

                // Vérifier si le mot clé est alphabétique
                if (isNaN(motCle)) {
                    // Recherche correspondance dans la table personnel
                    var personnelTrouve = <?php echo json_encode(rechercherPersonnel('')); ?>;
                    var personne = null;

                    for (var i = 0; i < personnelTrouve.length; i++) {
                        if (personnelTrouve[i]['prenom'] === motCle) {
                            personne = personnelTrouve[i];
                            break;
                        }
                    }

                    if (personne !== null) {
                        // Affiche l'alerte avec les détails de la personne trouvée
                        afficherAlerte("Le Nom '" + motCle + "' correspond à : " +
                            "ID Personnel: " + personne['id_personnel'] + ", " +
                            "Prénom: " + personne['prenom'] + ", " +
                            "Nom: " + personne['nom'] + ", " +
                            "Sexe: " + personne['sexe'] + ", " +
                            "Rôle: " + personne['role'] + ", " +
                            "ID Équipe: " + personne['id_equipe'], '#28a745');
                    } else {
                        // Affiche l'alerte indiquant que le nom n'est pas trouvé
                        afficherAlerte("Le Nom '" + motCle + "' est inconnu", '#dc3545');
                    }
                } else {
                    // Affiche l'alerte pour un mot clé non alphabétique
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
                    <a class="nav-link" href="#">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="equipes/equipe.php">Equipes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="personnel/personnel.php">Personnel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="rencontre/rencontre.php">Matchs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Deconnexion</a>
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


    <div class="container mt-5">
        <h1 class="text-center">Gestion des fonctionalités</h1>

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

    <?php include ('footer.php') ?>
</body>
</html>
