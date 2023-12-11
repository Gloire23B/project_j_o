<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Formulaire de Membre</title>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Formulaire de Membre</h2>

            <?php if (isset($erreur_message)) : ?>
                <div class="alert alert-danger text-center">
                    <?php echo $erreur_message; ?>
                    <br>
                    <a href="#" class="btn btn-warning mt-2" onclick="window.history.back();">Réessayer</a>
                    <a href="formulaire_membre.php" class="btn btn-secondary mt-2">Annuler</a>
                </div>
            <?php endif; ?>

            <form method="post" action="traitement_formulaire_membre.php">

                <div class="form-group">
                    <label for="login">Login :</label>
                    <input type="text" class="form-control" name="login" value="<?php echo isset($_POST['login']) ? htmlspecialchars($_POST['login']) : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="mdp">Mot de passe :</label>
                    <input type="password" class="form-control" name="mdp" required>
                </div>

                <button type="submit" class="btn btn-primary">Créer un compte</button>

            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
