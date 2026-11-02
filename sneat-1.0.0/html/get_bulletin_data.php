<?php
require_once 'db.php';

// 1. Validation des paramètres
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$rang = isset($_GET['rang']) ? htmlspecialchars($_GET['rang']) : '-';

if ($id <= 0) {
    echo '<div class="alert alert-danger m-3">Erreur : Identifiant étudiant invalide.</div>';
    exit;
}

try {
    // 2. Récupération des données
    $stmt = $pdo->prepare("SELECT * FROM etudiants WHERE id = ?");
    $stmt->execute([$id]);
    $e = $stmt->fetch();

    if (!$e) {
        echo '<div class="alert alert-warning m-3">Étudiant introuvable.</div>';
        exit;
    }

    $stmt = $pdo->prepare("
        SELECT m.nom_matiere, n.note_valeur, m.coefficient 
        FROM notes n 
        JOIN matieres m ON n.matiere_id = m.id 
        WHERE n.etudiant_id = ?
    ");
    $stmt->execute([$id]);
    $notes = $stmt->fetchAll();

    $total_points = 0;
    $total_coef = 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Aperçu Bulletin - <?= htmlspecialchars($e['nom']) ?></title>
    <link rel="stylesheet" href="../assets/vendor/css/core.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    
    <style>
        :root {
            --primary-color: #1a237e; /* Bleu Institutionnel */
            --bg-color: #f5f5f9;
        }

        body { background-color: var(--bg-color); padding: 20px; color: #333; }

        /* Conteneur "Feuille A4" */
        .bulletin-paper {
            background: white;
            max-width: 900px;
            margin: 0 auto;
            padding: 40px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }

        /* FILIGRANE */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 70px;
            color: rgba(26, 35, 126, 0.05); /* Très subtil */
            font-weight: bold;
            white-space: nowrap;
            z-index: 0;
            pointer-events: none;
            user-select: none;
        }

        /* ENTETE */
        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid var(--primary-color);
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo-box {
            width: 100px;
            height: 100px;
            border: 2px dashed #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 11px;
            color: #999;
        }

        .univ-details { text-align: right; }
        .univ-details h1 { color: var(--primary-color); font-weight: 800; margin-bottom: 5px; font-size: 24px; }

        /* INFOS ETUDIANT */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 30px;
            border: 1px solid #eee;
        }

        .info-item label { display: block; font-size: 11px; text-transform: uppercase; color: #777; margin-bottom: 3px; }
        .info-item span { font-weight: bold; font-size: 15px; color: #222; }

        /* TABLEAU */
        .table-custom { width: 100%; border-collapse: collapse; position: relative; z-index: 1; }
        .table-custom th { background: var(--primary-color); color: white; padding: 12px; text-align: left; font-size: 13px; }
        .table-custom td { padding: 12px; border-bottom: 1px solid #eee; font-size: 14px; }
        .table-custom tr:nth-child(even) { background-color: #fafafa; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }

        /* FOOTER BULLETIN */
        .footer-summary {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            align-items: flex-start;
        }

        .result-card {
            background: #e8eaf6;
            padding: 20px;
            border-radius: 8px;
            border-left: 5px solid var(--primary-color);
            min-width: 300px;
        }

        .decision-badge {
            font-size: 18px;
            font-weight: bold;
            color: <?= ($total_coef > 0 && ($total_points/$total_coef) >= 10) ? '#2e7d32' : '#c62828' ?>;
        }

        /* ACTIONS (BOUTONS) */
        .action-bar {
            max-width: 900px;
            margin: 0 auto 20px;
            display: flex;
            justify-content: space-between;
        }

        @media print {
            body { background: white; padding: 0; }
            .bulletin-paper { box-shadow: none; padding: 20px; }
            .action-bar, .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="action-bar no-print">
        <button onclick="window.close()" class="btn btn-outline-secondary">
            <i class="bx bx-arrow-back"></i> Retour
        </button>
        <div>
            <button onclick="window.print()" class="btn btn-primary me-2">
                <i class="bx bx-printer"></i> Imprimer
            </button>
            <a href="generer_pdf.php?id=<?= $id ?>&rang=<?= $rang ?>" class="btn btn-danger">
                <i class="bx bxs-file-pdf"></i> Télécharger PDF
            </a>
        </div>
    </div>

    <div class="bulletin-paper">
        <div class="watermark">ISMT SERVICES - OFFICIEL</div>

        <div class="header-top">
            <div class="logo-box">
                LOGO<br>UNIVERSITÉ
            </div>
            <div class="univ-details">
                <h1>ISMT SERVICES</h1>
                <p class="mb-0">République du Bénin</p>
                <small>Formation Professionnelle & Académique</small>
            </div>
        </div>

        <h3 class="text-center fw-bold mb-4" style="letter-spacing: 2px;">RELEVÉ DE NOTES SEMESTRIEL</h3>

        <div class="info-grid">
            <div class="info-item">
                <label>Nom & Prénoms</label>
                <span><?= htmlspecialchars(strtoupper($e['nom']) . ' ' . $e['prenom']) ?></span>
            </div>
            <div class="info-item">
                <label>Filière / Spécialité</label>
                <span><?= htmlspecialchars($e['filiere']) ?></span>
            </div>
            <div class="info-item">
                <label>Matricule</label>
                <span><?= htmlspecialchars($e['matricule']) ?></span>
            </div>
            <div class="info-item">
                <label>Niveau / Année</label>
                <span><?= htmlspecialchars($e['niveau']) ?> (2025-2026)</span>
            </div>
        </div>

        <table class="table-custom">
            <thead>
                <tr>
                    <th style="width: 50%;">Désignation des Matières</th>
                    <th class="text-center">Note / 20</th>
                    <th class="text-center">Coefficient</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($notes as $n): 
                    $pts = $n['note_valeur'] * $n['coefficient'];
                    $total_points += $pts;
                    $total_coef += $n['coefficient'];
                ?>
                <tr>
                    <td><?= htmlspecialchars($n['nom_matiere']) ?></td>
                    <td class="text-center fw-bold"><?= number_format($n['note_valeur'], 2) ?></td>
                    <td class="text-center"><?= $n['coefficient'] ?></td>
                    <td class="text-center fw-bold"><?= number_format($pts, 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot style="background: #eee; font-weight: bold;">
                <tr>
                    <td class="text-end">TOTAUX DU SEMESTRE</td>
                    <td></td>
                    <td class="text-center"><?= $total_coef ?></td>
                    <td class="text-center"><?= number_format($total_points, 2) ?></td>
                </tr>
            </tfoot>
        </table>

        <div class="footer-summary">
            <div class="result-card">
                <?php $moyenne = $total_coef > 0 ? ($total_points / $total_coef) : 0; ?>
                <p class="mb-2">Moyenne Générale : <span class="h4 fw-bold" style="color:var(--primary-color)"><?= number_format($moyenne, 2) ?> / 20</span></p>
                <p class="mb-2">Rang de l'élève : <strong><?= $rang ?></strong></p>
                <p class="mb-0 decision-badge">Résultat : <?= ($moyenne >= 10) ? 'ADMIS' : 'AJOURNÉ' ?></p>
            </div>
            <div class="text-center">
                <p class="mb-0">Fait à Cotonou, le <?= date('d/m/Y') ?></p>
                <p class="fw-bold text-decoration-underline">Le Directeur des Études</p>
                <div style="height: 80px;"></div>
                <p class="small text-muted italic">Document généré par le système ISMT</p>
            </div>
        </div>
    </div>

</body>
</html>
<?php
} catch (Exception $ex) {
    echo '<div class="alert alert-danger">Erreur : ' . $ex->getMessage() . '</div>';
}
?>