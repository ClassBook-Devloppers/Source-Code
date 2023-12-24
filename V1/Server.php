<?php
// Remplacez ces informations par vos propres paramètres de base de données
$serveur = "localhost";
$utilisateur_db = "votre_utilisateur";
$motdepasse_db = "votre_mot_de_passe";
$nom_db = "votre_base_de_donnees";

// Connexion à la base de données
$connexion = new mysqli($serveur, $utilisateur_db, $motdepasse_db, $nom_db);

// Vérifiez la connexion
if ($connexion->connect_error) {
    die("La connexion à la base de données a échoué : " . $connexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $utilisateur = $_POST['utilisateur'];
    $motdepasse = $_POST['motdepasse'];

    // Utilisation d'une requête préparée pour éviter les injections SQL
    $requete = $connexion->prepare("SELECT * FROM users WHERE name = ?");
    $requete->bind_param("s", $utilisateur);
    $requete->execute();
    $resultat = $requete->get_result();

    // Vérifiez si l'utilisateur existe et si le mot de passe est correct
    if ($resultat->num_rows > 0) {
        $utilisateur_bd = $resultat->fetch_assoc();
        if (password_verify($motdepasse, $utilisateur_bd['motdepasse'])) {
            // L'utilisateur est authentifié, vous pouvez rediriger ou afficher le contenu protégé ici
            echo '<h1>Bienvenue, ' . htmlspecialchars($utilisateur) . ' !</h1>';
        } else {
            // Mot de passe incorrect
            echo '<h2>Identifiants incorrects. Veuillez réessayer.</h2>';
        }
    } else {
        // L'utilisateur n'existe pas
        echo '<h2>Utilisateur inexistant. Veuillez réessayer.</h2>';
    }

    // Fermer la requête et la connexion
    $requete->close();
    $connexion->close();
}
?>
```

Dans cet exemple, j'ai supposé que votre table s'appelle `users` et a les colonnes `name` et `motdepasse` pour le nom d'utilisateur et le mot de passe. Assurez-vous d'ajuster ces informations en fonction de votre propre schéma de base de données. De plus, il est toujours recommandé d'utiliser des requêtes préparées pour éviter les attaques par injection SQL, et d'utiliser des fonctions de hachage sécurisées (comme `password_hash` et `password_verify`) pour stocker les mots de passe.