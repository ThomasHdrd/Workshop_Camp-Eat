<?php
// Vérifie si la méthode de la requête est POST (indiquant que des données ont été envoyées via un formulaire)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Récupération des données du formulaire envoyées via POST
    $name = $_POST['name'];                   // Récupère le nom de l'utilisateur
    $firstName = $_POST['firstName'];         // Récupère le prénom de l'utilisateur
    $phone = $_POST['phone'];                 // Récupère le numéro de téléphone de l'utilisateur
    $mail = $_POST['mail'];                   // Récupère l'adresse e-mail de l'utilisateur
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage sécurisé 

    // Informations de connexion à la base de données
    $dsn = 'mysql:host=localhost;dbname=basedd_test;charset=utf8mb4'; // Chaîne de connexion à la base de données
    $username = 'root';     // Nom d'utilisateur de la base de données (root = serveur local)
    $dbpassword = '';       // Mot de passe de la base de données (vide par défaut (XAMPP))

    try {
        // Création d'une connexion à la base de données avec PDO (permet à PHP de se connecter avec des bases de données)
        $pdo = new PDO($dsn, $username, $dbpassword);

        // Définir le mode d'erreur PDO
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupération du résultat de la requête sous forme associative (stocker des données avec des clés personnalisées)
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, telephone, email, mot_de_passe) VALUES (?, ?, ?, ?, ?)");

         // Requête préparée avec les variables prédéfini auparavant
         ($stmt->execute([$name, $firstName, $phone, $mail, $password])) {
             // Si la requête est réussie, renvoyer une réponse JSON indiquant "Inscriptipn réussie !"
            echo json_encode(["success" => true, "message" => "Inscription réussie !"]);
        } else {
            // Si requête échoue, renvoyer une réponse JSON avec un message "Erreur lors de l'inscription."
            echo json_encode(["success" => false, "message" => "Erreur lors de l'inscription."]);
        }
        exit;

        // Affiche toute erreur de connexion ou d'exécution
    } catch (PDOException $e) {
        // En cas d'erreur, affiche le message d'erreur PDO
        echo "Erreur : " . $e->getMessage();
    }
}
?>