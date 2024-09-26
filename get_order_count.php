<?php
header('Content-Type: application/json');

try {

    $dsn = 'mysql:host=localhost;dbname=basedd_test;charset=utf8mb4';
    $username = 'root';
    $dbpassword = '';

    $pdo = new PDO($dsn, $username, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT COUNT(*) AS row_count FROM `order`");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "count" => $result['row_count']
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Erreur de base de données : " . $e->getMessage()
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Erreur inattendue : " . $e->getMessage()
    ]);
}
?>