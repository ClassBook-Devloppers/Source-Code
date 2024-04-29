<?php
session_start();

$servername = "localhost";
$username = "classbook";
$password = "classbook123";
$dbname = "users";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT id FROM utilisateurs WHERE nom_utilisateur='$username' AND mot_de_passe='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $userId = $row['id'];

            $sessionToken = generateSessionToken();

            $sql = "UPDATE utilisateurs SET session_token='$sessionToken' WHERE id='$userId'";
            if ($conn->query($sql) === TRUE) {
                $_SESSION['user_id'] = $userId;
                $_SESSION['session_token'] = $sessionToken;

                header("Location: index.php");
                exit();
            } else {
                echo "Erreur lors de l'enregistrement du jeton de session dans la base de données.";
            }
        } else {
            echo "Nom d'utilisateur ou mot de passe incorrect.";
        }
    }
}

function generateSessionToken() {
    return bin2hex(random_bytes(32)); 
}

$conn->close();
?>
