<?php
// Autoriser l'origine de ton application Vue.js
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Gérer les requêtes préflight (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); // Pas de contenu
    exit();
}

// Activer l'affichage des erreurs pour le développement
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclure la configuration de la base de données
$config = include(__DIR__ . '/config/bdd.php');

// Vérifier que la configuration est bien chargée
if (!$config || !isset($config['host'], $config['username'], $config['password'], $config['dbname'])) {
    echo json_encode(["error" => "Erreur de chargement de la configuration de la base de données."]);
    exit();
}

try {
    $conn = new PDO(
        "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8",
        $config['username'],
        $config['password']
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["error" => "Erreur de connexion à la base de données : " . $e->getMessage()]);
    exit();
}

// Vérifier si l'action demandée est présente
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'register':
            registerUtilisateur($conn);
            break;
        case 'login':
            loginUtilisateur($conn);
            break;
        case 'get_inventory':
            getInventory($conn);
            break;
        case 'get_hints':
            getHints($conn);
            break;
        case 'scenario': // Nouvelle action pour le scénario
            getScenario($conn);
            break;
        case 'resultat': // Nouvelle action pour le résultat
            getResultat($conn);
            break;
        default:
            echo json_encode(["error" => "Action inconnue."]);
            break;
    }
}

// Fonction pour récupérer le scénario
function getScenario($conn) {
    // Exemple de scénario statique
    $scenario = "Vous vous réveillez dans une pièce sombre. Vous devez résoudre des énigmes pour vous échapper.";
    
    // Si tu veux récupérer le scénario depuis la base de données, tu peux le faire comme ceci :
    // $sql = "SELECT scenario_description FROM scenarios WHERE room_id = :room_id";
    // $stmt = $conn->prepare($sql);
    // $stmt->execute();
    // $scenario = $stmt->fetch(PDO::FETCH_ASSOC)['scenario_description'];

    echo json_encode(['scenario' => $scenario]);
}

// Fonction pour récupérer le résultat
function getResultat($conn) {
    // Exemple de résultat statique
    $resultat = "Vous avez réussi à vous échapper en 20 minutes !";
    $score = 100; // Exemple de score

    // Si tu veux récupérer le résultat depuis la base de données, tu peux le faire comme ceci :
    // $sql = "SELECT result_text, score FROM results WHERE user_id = :user_id";
    // $stmt = $conn->prepare($sql);
    // $stmt->bindParam(':user_id', $user_id);
    // $stmt->execute();
    // $resultat = $stmt->fetch(PDO::FETCH_ASSOC)['result_text'];
    // $score = $stmt->fetch(PDO::FETCH_ASSOC)['score'];

    echo json_encode(['resultat' => $resultat, 'score' => $score]);
}

// Fonction d'inscription
function registerUtilisateur($conn) {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data) {
        echo json_encode(["error" => "Erreur de format JSON."]);
        exit();
    }

    $username = htmlspecialchars($data['username'], ENT_QUOTES, 'UTF-8');
    $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
    $password = $data['password'];

    if (empty($username) || empty($email) || empty($password)) {
        echo json_encode(["error" => "Tous les champs sont obligatoires."]);
        exit();
    }

    // Vérifier si l'email existe déjà dans la table 'users'
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    if ($stmt->fetch()) {
        echo json_encode(["error" => "Cet email est déjà utilisé."]);
        exit();
    }

    // Hachage du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insérer l'utilisateur dans la table 'users'
    $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password_hash)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password_hash', $hashedPassword);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Inscription réussie."]);
    } else {
        echo json_encode(["error" => "Erreur lors de l'inscription."]);
    }
}

// Fonction de connexion
function loginUtilisateur($conn) {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['email'], $data['password'])) {
        echo json_encode(["error" => "Données incomplètes"]);
        return;
    }

    $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
    $password = $data['password'];

    // Vérifier si l'email existe dans la table 'users'
    $stmt = $conn->prepare("SELECT user_id, password_hash FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Vérifier le mot de passe
        if (password_verify($password, $user['password_hash'])) {
            echo json_encode(["success" => true, "message" => "Connexion réussie."]);
        } else {
            echo json_encode(["error" => "Mot de passe incorrect"]);
        }
    } else {
        echo json_encode(["error" => "Utilisateur non trouvé"]);
    }
}

// API pour obtenir l'inventaire d'un utilisateur
function getInventory($conn) {
    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;
    if (!$user_id) {
        echo json_encode(["error" => "ID utilisateur manquant."]);
        exit();
    }

    // Requête pour obtenir l'inventaire d'un utilisateur
    $sql = "SELECT objet_nom, quantite FROM inventory WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["inventory" => $inventory]);
}

// API pour obtenir les indices
function getHints($conn) {
    $room_id = isset($_GET['room_id']) ? $_GET['room_id'] : 1; // Salle par défaut
    $sql = "SELECT hint_text FROM hints WHERE room_id = :room_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':room_id', $room_id);
    $stmt->execute();
    $hints = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["hints" => $hints]);
}

// Fonction pour récupérer le résultat d'un utilisateur
function getResultat($conn) {
    // Vérification que l'ID utilisateur est bien passé dans la requête
    $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

    if ($user_id <= 0) {
        echo json_encode(["error" => "ID utilisateur invalide."]);
        exit();
    }

    try {
        // Requête pour récupérer le résultat depuis la base de données
        $stmt = $conn->prepare("SELECT result_text, score FROM results WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode([
                "resultat" => $result['result_text'],
                "score" => intval($result['score'])
            ]);
        } else {
            echo json_encode(["message" => "Aucun résultat trouvé pour cet utilisateur."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["error" => "Erreur lors de la récupération des résultats : " . $e->getMessage()]);
    }
}

?>
