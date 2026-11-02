<?php
require_once 'db.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // 1. (Optionnel) Supprimer la photo du dossier uploads pour ne pas encombrer le serveur
        $query = $pdo->prepare("SELECT photo FROM etudiants WHERE id = ?");
        $query->execute([$id]);
        $etudiant = $query->fetch();

        if ($etudiant && $etudiant['photo'] != 'default.png') {
            $path = "uploads/" . $etudiant['photo'];
            if (file_exists($path)) {
                unlink($path); // Supprime le fichier physique
            }
        }

        // 2. Supprimer l'entrée dans la base de données
        $delete = $pdo->prepare("DELETE FROM etudiants WHERE id = ?");
        $delete->execute([$id]);

        // Redirection avec un message de succès (on pourrait utiliser une session pour l'alerte)
        header("Location: etudiants.php?status=deleted");
        exit();

    } catch (PDOException $e) {
        die("Erreur lors de la suppression : " . $e->getMessage());
    }
} else {
    header("Location: etudiants.php");
    exit();
}