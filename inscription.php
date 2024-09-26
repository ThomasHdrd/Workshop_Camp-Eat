<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $name = $_POST['name'];
    $firstName = $_POST['firstName'];
    $phone = $_POST['phone'];
    $mail = $_POST['mail'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage du mot de passe

    // Connexion à la base de données
    $dsn = 'mysql:host=localhost;dbname=basedd_test;charset=utf8mb4';
    $username = 'root';
    $dbpassword = '';

    try {
        $pdo = new PDO($dsn, $username, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparation et exécution de la requête
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, telephone, email, mot_de_passe) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$name, $firstName, $phone, $mail, $password])) {
            echo json_encode(["success" => true, "message" => "Inscription réussie !"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors de l'inscription."]);
        }
        exit;

        
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>