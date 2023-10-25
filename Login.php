<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $utilisateur = $_POST["utilisateur"];
    $motdepasse = $_POST["motdepasse"];

    // Assurez-vous de stocker les informations d'authentification en toute sécurité dans votre application
    // Remplacez la vérification factice ci-dessous par votre propre logique d'authentification

    $utilisateur_valide = "utilisateur"; // Remplacez par le nom d'utilisateur valide
    $motdepasse_valide = "motdepasse"; // Remplacez par le mot de passe valide

    if ($utilisateur === $utilisateur_valide && $motdepasse === $motdepasse_valide) {
        echo "success"; // Vous pouvez renvoyer d'autres données si nécessaire
        exit;
    } else {
        echo "error";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Mettez ici vos balises meta, title, et styles -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>body {
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
            width: 281px;
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
        }</style>
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h2>Connexion</h2>
            <form id="login-form">
                <div class="input-box">
                    <input type="text" name="utilisateur" placeholder="Nom d'utilisateur" required>
                </div>
                <div class="input-box">
                    <input type="password" name="motdepasse" id="motdepasse" placeholder="Mot de passe" required>
                </div>
                <button type="submit" class="login-button">Se connecter</button>
            </form>
            <p><a href="inscription.php">S'inscrire</a></p>
            <p id="message"></p>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#login-form").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response === "success") {
                            // L'authentification a réussi
                            $("#message").text("Authentification réussie, redirection en cours...");
                            window.location.href = "page_protegee.php";
                        } else {
                            // L'authentification a échoué
                            $("#message").text("Nom d'utilisateur ou mot de passe incorrect.");
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
