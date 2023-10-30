<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $utilisateur = $_POST['utilisateur'];
    $motdepasse = $_POST['motdepasse'];

    // Exemple d'authentification
    if ($utilisateur === 'CDI-Owner' && $motdepasse === 'MotDePasseAdmin') {
        // Authentification réussie, redirigez vers l'interface d'administration
        header('Location: ../admin/');
        exit;
    } else {
        // Authentification échouée, redirigez vers la page de connexion avec un message d'erreur
        header('Location: ../public/?erreur=1');
        exit;
    }
}
