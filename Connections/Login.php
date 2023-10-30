<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
        }

        .login-box {
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .input-box {
            margin-bottom: 15px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            outline: none;
        }

        .login-button {
            background-color: #0078d4;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 3px;
            cursor: pointer;
        }

        .login-button:hover {
            background-color: #0056b3;
        }

        p {
            margin-top: 10px;
        }

        a {
            text-decoration: none;
            color: #0078d4;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
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

    <div class="container">
        <div class="login-box">
            <h2>Connexion</h2>
            <form action="" method="POST" onsubmit="return validateForm();">
                <div class="input-box">
                    <input type="text" name="utilisateur" placeholder="Nom d'utilisateur" required>
                </div>
                <div class="input-box">
                    <input type="password" name="motdepasse" id="motdepasse" placeholder="Mot de passe" required>
                </div>
                <button type="submit" class="login-button">Se connecter</button>
            </form>
            <p><a href="inscription.php">S'inscrire</a></p>
        </div>
    </div>

    <script>
        function validateForm() {
            var motdepasse = document.getElementById("motdepasse").value;

            // Vérification de la longueur du mot de passe
            if (motdepasse.length < 8) {
                alert("Le mot de passe doit comporter au moins 8 caractères.");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
