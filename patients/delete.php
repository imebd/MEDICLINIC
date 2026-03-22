<?php
require_once '../config/database.php';

$id = $_GET['id'] ?? null;
if ($id) {
    try {
        $sql = "DELETE FROM patients WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        header("Location: index.php?deleted=1");
        exit();

    } catch (PDOException $e) {
        die("Erreur lors de la suppression : " . $e->getMessage());
    }
} else {
    header("Location: index.php");
    exit();
}