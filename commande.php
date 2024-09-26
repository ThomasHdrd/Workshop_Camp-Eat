<?php

// Vérification si la requête est bien envoyée par la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = 1;           // Identifiant de l'utilisateur (statique pour cet exemple)
    $foodtruck_id = 2;      // Identifiant du foodtruck (statique pour cet exemple)
    $day_id = 3;            // Identifiant du jour (statique pour cet exemple)

    // Informations de connexion à la base de données
    $dsn = 'mysql:host=localhost;dbname=basedd_test;charset=utf8mb4'; // Chaîne de connexion à la base de données
    $username = 'root';     // Nom d'utilisateur de la base de données (root = serveur local)
    $dbpassword = '';       // Mot de passe de la base de données (vide par défaut (XAMPP))

    try {
        // Création d'une connexion à la base de données avec PDO (permet à PHP de se connecter avec des bases de données)
        $pdo = new PDO($dsn, $username, $dbpassword);

        // Définir le mode d'erreur PDO
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête SQL pour insérer les données dans la table "order"
        $stmt = $pdo->prepare("INSERT INTO `order` (user_id, foodtruck_id, day_id) VALUES (?, ?, ?)");
        
        // Requête préparée avec les variables prédéfini auparavant
        if ($stmt->execute([$user_id, $foodtruck_id, $day_id])) {
            // Si la requête est réussie, renvoyer une réponse JSON indiquant "Commande réussie !"
            echo json_encode(["success" => true, "message" => "Commande réussie !"]);
        } else {
            // Si requête échoue, renvoyer une réponse JSON avec un message "Erreur lors de votre commande."
            echo json_encode(["success" => false, "message" => "Erreur lors de votre commande."]);
        }
        exit;

    // Affiche toute erreur de connexion ou d'exécution
    } catch (PDOException $e) {
        // En cas d'erreur, affiche le message d'erreur PDO
        echo "Erreur : " . $e->getMessage();
    }
}
?>
