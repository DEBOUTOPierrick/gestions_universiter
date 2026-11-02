<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['notes'])) {
    $matiere_id = $_POST['matiere_id'];
    $notes = $_POST['notes'];
    $filiere = $_POST['filiere_hidden'];
    $niveau = $_POST['niveau_hidden'];

    try {
        $pdo->beginTransaction();

        $sql = "INSERT INTO notes (etudiant_id, matiere_id, note_valeur) 
                VALUES (:eid, :mid, :val) 
                ON DUPLICATE KEY UPDATE note_valeur = :val";
        
        $stmt = $pdo->prepare($sql);

        foreach ($notes as $etudiant_id => $valeur) {
            if ($valeur !== "") {
                // SÉCURITÉ SERVEUR : Bloquer si > 20
                if ($valeur > 20 || $valeur < 0) {
                    throw new Exception("Erreur Critique : Une note ne peut pas excéder 20.");
                }

                $stmt->execute([
                    ':eid' => $etudiant_id,
                    ':mid' => $matiere_id,
                    ':val' => $valeur
                ]);
            }
        }

        $pdo->commit();
        header("Location: notes.php?filiere=$filiere&niveau=$niveau&matiere=$matiere_id&msg=success");
    } catch (Exception $e) {
        $pdo->rollBack();
        die("Erreur de sauvegarde : " . $e->getMessage());
    }
}