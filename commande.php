<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = 1;
    $foodtruck_id = 2;
    $day_id = 3;

    // Connexion à la base de données
    $dsn = 'mysql:host=localhost;dbname=basedd_test;charset=utf8mb4';
    $username = 'root';
    $dbpassword = '';

    try {
        $pdo = new PDO($dsn, $username, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparation et exécution de la requête
        $stmt = $pdo->prepare("INSERT INTO `order` (user_id, foodtruck_id, day_id) VALUES (?, ?, ?)");
        if ($stmt->execute([$user_id, $foodtruck_id, $day_id])) {
            echo json_encode(["success" => true, "message" => "Commande réussie !"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors de votre commande."]);
        }
        exit;

        
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>