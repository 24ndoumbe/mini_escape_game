<?php
$servername = "localhost";  // ou "127.0.0.1" selon ta configuration
$username = "root";         // Nom d'utilisateur de MySQL
$password = "";             // Mot de passe de MySQL
$dbname = "mini_scape_game";    // Nom de ta base de données

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
