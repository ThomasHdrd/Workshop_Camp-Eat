<?php

// Vérification si la requête est bien envoyée par la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Variables fixées pour l'exemple (peut être récupérées dynamiquement via un formulaire dans un cas réel)
    $user_id = 1;           // Identifiant de l'utilisateur (statique pour cet exemple)
    $foodtruck_id = 2;      // Identifiant du foodtruck (statique pour cet exemple)
    $day_id = 3;            // Identifiant du jour (statique pour cet exemple)

    // Informations de connexion à la base de données
    $dsn = 'mysql:host=localhost;dbname=basedd_test;charset=utf8mb4'; // Chaîne de connexion à la base de données (DSN)
    $username = 'root';     // Nom d'utilisateur de la base de données (root pour un serveur local)
    $dbpassword = '';       // Mot de passe de la base de données (vide par défaut sur un serveur local comme XAMPP)

    try {
        // Création d'une connexion à la base de données avec PDO
        $pdo = new PDO($dsn, $username, $dbpassword);
        // Définir le mode d'erreur PDO pour lancer une exception en cas d'erreur
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparation de la requête SQL pour insérer les données dans la table "order"
        $stmt = $pdo->prepare("INSERT INTO `order` (user_id, foodtruck_id, day_id) VALUES (?, ?, ?)");
        
        // Exécution de la requête préparée avec les valeurs dynamiques des variables
        if ($stmt->execute([$user_id, $foodtruck_id, $day_id])) {
            // Si la requête est réussie, renvoyer une réponse JSON indiquant le succès
            echo json_encode(["success" => true, "message" => "Commande réussie !"]);
        } else {
            // Si l'insertion échoue, renvoyer une réponse JSON avec un message d'erreur
            echo json_encode(["success" => false, "message" => "Erreur lors de votre commande."]);
        }
        // Quitte le script une fois la réponse envoyée
        exit;

    // Bloc de gestion des erreurs (exceptions) pour capturer et afficher toute erreur de connexion ou d'exécution
    } catch (PDOException $e) {
        // En cas d'erreur, affiche le message d'erreur PDO
        echo "Erreur : " . $e->getMessage();
    }
}
?>
