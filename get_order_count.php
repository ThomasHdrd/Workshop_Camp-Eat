<?php
// Indique au navigateur que le contenu renvoyé sera au format JSON
header('Content-Type: application/json');

try {

    // Informations de connexion à la base de données MySQL
    $dsn = 'mysql:host=localhost;dbname=basedd_test;charset=utf8mb4'; // DSN (Data Source Name), spécifie l'hôte, le nom de la base de données, et le jeu de caractères
    $username = 'root';     // Nom d'utilisateur de la base de données (par défaut "root" pour un serveur local)
    $dbpassword = '';       // Mot de passe de la base de données (vide par défaut sur des serveurs locaux comme XAMPP ou WAMP)

    // Connexion à la base de données via PDO (PHP Data Objects)
    $pdo = new PDO($dsn, $username, $dbpassword);
    
    // Configuration de l'option pour lever des exceptions en cas d'erreur
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparation et exécution d'une requête SQL pour compter les lignes dans la table "order"
    $stmt = $pdo->query("SELECT COUNT(*) AS row_count FROM `order`");

    // Récupération du résultat de la requête sous forme associative
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Envoie une réponse JSON contenant le résultat de la requête
    echo json_encode([
        "success" => true,                // Indique que la requête a réussi
        "count" => $result['row_count']   // Retourne le nombre de lignes dans la table "order"
    ]);

} catch (PDOException $e) {
    // Gestion des erreurs liées à la base de données (problèmes de connexion, requêtes, etc.)
    echo json_encode([
        "success" => false,
        "message" => "Erreur de base de données : " . $e->getMessage()  // Envoie un message d'erreur si une exception PDO est levée
    ]);
} catch (Exception $e) {
    // Gestion des autres types d'erreurs inattendues
    echo json_encode([
        "success" => false,
        "message" => "Erreur inattendue : " . $e->getMessage()  // Envoie un message d'erreur générique pour les autres exceptions
    ]);
}
?>
