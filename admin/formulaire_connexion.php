<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Connexion</title>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Connexion</h2>

            <?php
            session_start();

            // Vérifier si l'utilisateur est déjà connecté
            if (isset($_SESSION['id'])) {
                // Rediriger vers la page appropriée
                if ($_SESSION['login'] === 'gloire') {
                    header("Location: ../gestion.php");
                } else {
                    header("Location: ../index.php");
                }
                exit();
            }

            // Traitement de la connexion
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                require('traitement_connexion.php');
            }
            ?>

            <!-- Formulaire de connexion -->
            <form method="post" action="">
                <div class="form-group">
                    <label for="login">Login :</label>
                    <input type="text" class="form-control" id="login" name="login" required>
                </div>
                <div class="form-group">
                    <label for="mdp">Mot de passe :</label>
                    <input type="password" class="form-control" id="mdp" name="mdp" required>
                </div>
                <button type="submit" class="btn btn-primary">Connexion</button>
            </form>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
