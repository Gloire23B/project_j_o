<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lieu = $_POST['lieu'];
    $type = $_POST['type'];
    $equipe_a = $_POST['equipe_a'];
    $equipe_b = $_POST['equipe_b'];
    $date_rencontre = $_POST['date_rencontre'];

    // Assurez-vous de valider et échapper les données avant de les utiliser dans une requête SQL

    $sql = "INSERT INTO rencontre (lieu, type, id_equipe_a, id_equipe_b, date_rencontre) 
            VALUES ('$lieu', '$type', $equipe_a, $equipe_b, '$date_rencontre')";

    if ($conn->query($sql) === TRUE) {
        echo "Match planifié avec succès!";
    } else {
        echo "Erreur lors de la planification du match: " . $conn->error;
    }

    $conn->close();
}
?>
