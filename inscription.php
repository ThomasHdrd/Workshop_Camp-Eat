<?php
// Vérifie si la méthode de la requête est POST (indiquant que des données ont été envoyées via un formulaire)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Récupération des données du formulaire envoyées via POST
    $name = $_POST['name'];                   // Récupère le nom de l'utilisateur
    $firstName = $_POST['firstName'];         // Récupère le prénom de l'utilisateur
    $phone = $_POST['phone'];                 // Récupère le numéro de téléphone de l'utilisateur
    $mail = $_POST['mail'];                   // Récupère l'adresse e-mail de l'utilisateur
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage sécurisé du mot de passe pour stocker en base

    // Informations de connexion à la base de données
    $dsn = 'mysql:host=localhost;dbname=basedd_test;charset=utf8mb4'; // DSN (Data Source Name), contient l'hôte, la base de données, et l'encodage des caractères
    $username = 'root';       // Nom d'utilisateur de la base de données (par défaut, root en local)
    $dbpassword = '';         // Mot de passe de la base de données (vide par défaut sur un serveur local comme XAMPP)

    try {
        // Création d'une connexion à la base de données via PDO
        $pdo = new PDO($dsn, $username, $dbpassword);
        // Active le mode d'erreur pour lever une exception en cas de problème
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparation de la requête d'insertion pour ajouter un nouvel utilisateur
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, telephone, email, mot_de_passe) VALUES (?, ?, ?, ?, ?)");

        // Exécution de la requête préparée avec les données utilisateur
        if ($stmt->execute([$name, $firstName, $phone, $mail, $password])) {
            // Si l'insertion réussit, on renvoie une réponse JSON indiquant le succès
            echo json_encode(["success" => true, "message" => "Inscription réussie !"]);
        } else {
            // Si l'insertion échoue, on renvoie une réponse JSON avec un message d'erreur
            echo json_encode(["success" => false, "message" => "Erreur lors de l'inscription."]);
        }

        // Terminer le script après avoir renvoyé la réponse JSON
        exit;

    } catch (PDOException $e) {
        // Si une erreur liée à la base de données survient, on affiche un message d'erreur
        echo "Erreur : " . $e->getMessage();
    }
}
?>