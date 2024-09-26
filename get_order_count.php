<?php
// Indique au navigateur que le contenu renvoyé sera au format JSON
header('Content-Type: application/json');

try {

    // Informations de connexion à la base de données
    $dsn = 'mysql:host=localhost;dbname=basedd_test;charset=utf8mb4'; // Chaîne de connexion à la base de données
    $username = 'root';     // Nom d'utilisateur de la base de données (root = serveur local)
    $dbpassword = '';       // Mot de passe de la base de données (vide par défaut (XAMPP))

    // Création d'une connexion à la base de données avec PDO (permet à PHP de se connecter avec des bases de données)
    $pdo = new PDO($dsn, $username, $dbpassword);
    
    // Définir le mode d'erreur PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL pour insérer les données dans la table "order"
    $stmt = $pdo->query("SELECT COUNT(*) AS row_count FROM `order`");

    // Récupération du résultat de la requête sous forme associative (stocker des données avec des clés personnalisées)
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Envoi une réponse JSON contenant le résultat de la requête
    echo json_encode([
        "success" => true,                // Indique que la requête a réussi
        "count" => $result['row_count']   // Retourne le nombre de lignes dans la table "order"
    ]);

} catch (PDOException $e) {
    // Gestion des erreurs liées à la base de données (problèmes de connexion, requêtes)
    echo json_encode([
        "success" => false,
        "message" => "Erreur de base de données : " . $e->getMessage()  // Envoie un message d'erreur
    ]);

} catch (Exception $e) {
    // Gestion des autres types d'erreurs inattendues
    echo json_encode([
        "success" => false,
        "message" => "Erreur inattendue : " . $e->getMessage()  // Envoie un message d'erreur pour les autres exceptions
    ]);
}
?>
