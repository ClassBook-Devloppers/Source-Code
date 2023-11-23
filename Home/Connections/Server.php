<?php
        // Exemple d'ID d'utilisateur, à remplacer par votre logique de base de données
        $utilisateurs = [
            'utilisateur1' => ['motdepasse' => 'MotDePasse1'],
            'utilisateur2' => ['motdepasse' => 'MotDePasse2'],
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $utilisateur = $_POST['utilisateur'];
            $motdepasse = $_POST['motdepasse'];

            if (array_key_exists($utilisateur, $utilisateurs) && $utilisateurs[$utilisateur]['motdepasse'] === $motdepasse) {
                // L'utilisateur est authentifié, vous pouvez rediriger ou afficher le contenu protégé ici
                echo '<h1>Bienvenue, ' . htmlspecialchars($utilisateur) . ' !</h1>';
            } else {
                // L'utilisateur n'a pas pu être authentifié, affichez un message d'erreur
                echo '<h2>Identifiants incorrects. Veuillez réessayer.</h2>';
            }
        }
    ?>
