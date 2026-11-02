<?php
require_once 'db.php';

// Chemin vers Dompdf (Vérifiez bien ce chemin après votre extraction manuelle)
$dompdfPath = __DIR__ . '/../assets/vendor/libs/dompdf/autoload.inc.php';

if (!file_exists($dompdfPath)) {
    die("Bibliothèque Dompdf introuvable. Veuillez l'installer dans : " . $dompdfPath);
}

require_once $dompdfPath;

use Dompdf\Dompdf;
use Dompdf\Options;

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$rang = isset($_GET['rang']) ? htmlspecialchars($_GET['rang']) : '-';

try {
    // 1. Données
    $stmt = $pdo->prepare("SELECT * FROM etudiants WHERE id = ?");
    $stmt->execute([$id]);
    $student = $stmt->fetch();
    
    $stmt = $pdo->prepare("SELECT m.nom_matiere, n.note_valeur, m.coefficient FROM notes n JOIN matieres m ON n.matiere_id = m.id WHERE n.etudiant_id = ?");
    $stmt->execute([$id]);
    $notes = $stmt->fetchAll();

    $totalPoints = 0; $totalCoeff = 0;
    $rowsHtml = "";
    foreach ($notes as $n) {
        $pts = $n['note_valeur'] * $n['coefficient'];
        $totalPoints += $pts; $totalCoeff += $n['coefficient'];
        $rowsHtml .= "<tr>
            <td>{$n['nom_matiere']}</td>
            <td class='center bold'>" . number_format($n['note_valeur'], 2) . "</td>
            <td class='center'>{$n['coefficient']}</td>
            <td class='center bold'>" . number_format($pts, 2) . "</td>
        </tr>";
    }
    $moyenne = $totalCoeff > 0 ? ($totalPoints / $totalCoeff) : 0;

    // 2. Construction du HTML avec CSS Intégré pour Dompdf
    $html = "
    <html>
    <head>
        <style>
            @page { margin: 0px; }
            body { font-family: 'Helvetica', sans-serif; margin: 0; padding: 0; color: #333; }
            
            /* FILIGRANE */
            .watermark {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) rotate(-45deg);
                font-size: 80px;
                color: rgba(220, 220, 220, 0.2);
                z-index: -1000;
                width: 100%;
                text-align: center;
                font-weight: bold;
                text-transform: uppercase;
            }

            .container { padding: 40px; }

            /* ENTETE */
            .header-table { width: 100%; border-bottom: 3px solid #1a237e; padding-bottom: 20px; }
            .logo-placeholder { width: 120px; height: 120px; border: 1px dashed #ccc; text-align: center; line-height: 120px; font-size: 12px; color: #999; }
            .university-info { text-align: right; }
            .university-name { font-size: 22px; font-weight: bold; color: #1a237e; margin: 0; }
            
            .doc-title { text-align: center; background: #f5f5f5; padding: 10px; margin: 20px 0; font-size: 20px; font-weight: bold; border-radius: 5px; }

            /* INFO ETUDIANT */
            .student-info { width: 100%; margin-bottom: 30px; border: 1px solid #eee; padding: 15px; border-radius: 8px; background-color: #fafafa; }
            .label { color: #666; font-size: 11px; text-transform: uppercase; }
            .value { font-weight: bold; font-size: 14px; }

            /* TABLEAU */
            table.notes-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
            table.notes-table th { background-color: #1a237e; color: white; padding: 12px; font-size: 12px; text-align: left; }
            table.notes-table td { padding: 10px; border-bottom: 1px solid #eee; font-size: 12px; }
            table.notes-table tr:nth-child(even) { background-color: #fcfcfc; }
            .center { text-align: center; }
            .bold { font-weight: bold; }

            /* BILAN */
            .bilan-section { margin-top: 30px; width: 100%; }
            .moyenne-card { background: #e8eaf6; padding: 20px; border-radius: 8px; border-left: 5px solid #1a237e; }
            .decision { font-size: 18px; font-weight: bold; color: " . ($moyenne >= 10 ? '#2e7d32' : '#c62828') . "; }

            /* FOOTER */
            .signature-area { margin-top: 50px; text-align: right; padding-right: 50px; }
        </style>
    </head>
    <body>
        <div class='watermark'>ISMT SERVICES - OFFICIEL</div>

        <div class='container'>
            <table class='header-table'>
                <tr>
                    <td width='150'>
                        <div class='logo-placeholder'>
                            LOGO ICI<br>
                            <small>(image/logo.png)</small>
                        </div>
                    </td>
                    <td class='university-info'>
                        <h1 class='university-name'>UNIVERSITÉ ISMT SERVICES</h1>
                        <p>Administration Académique et Scolarité<br>
                        BP: 1234 Cotonou, République du Bénin<br>
                        Contact: info@ismt-services.com</p>
                    </td>
                </tr>
            </table>

            <div class='doc-title'>BULLETIN DE NOTES SEMESTRIEL</div>

            <table class='student-info'>
                <tr>
                    <td width='50%'>
                        <span class='label'>Étudiant</span><br>
                        <span class='value'>" . htmlspecialchars(strtoupper($student['nom']) . " " . $student['prenom']) . "</span>
                    </td>
                    <td>
                        <span class='label'>Filière & Niveau</span><br>
                        <span class='value'>" . htmlspecialchars($student['filiere']) . " - " . htmlspecialchars($student['niveau']) . "</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class='label'>Matricule</span><br>
                        <span class='value'>" . htmlspecialchars($student['matricule']) . "</span>
                    </td>
                    <td>
                        <span class='label'>Année Académique</span><br>
                        <span class='value'>2025 - 2026</span>
                    </td>
                </tr>
            </table>

            <table class='notes-table'>
                <thead>
                    <tr>
                        <th width='50%'>DESIGNATION DES MATIÈRES</th>
                        <th class='center'>NOTE / 20</th>
                        <th class='center'>COEFF</th>
                        <th class='center'>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    $rowsHtml
                </tbody>
                <tfoot style='background: #f5f5f5;'>
                    <tr class='bold'>
                        <td style='text-align: right;'>TOTAUX</td>
                        <td class='center'>-</td>
                        <td class='center'>$totalCoeff</td>
                        <td class='center'>" . number_format($totalPoints, 2) . "</td>
                    </tr>
                </tfoot>
            </table>

            <table class='bilan-section'>
                <tr>
                    <td width='60%'>
                        <div class='moyenne-card'>
                            <p style='margin:0'>Moyenne Générale : <span style='font-size:22px; font-weight:bold; color:#1a237e;'>" . number_format($moyenne, 2) . " / 20</span></p>
                            <p style='margin:5px 0'>Rang : <b>$rang</b></p>
                            <p style='margin:0' class='decision'>Résultat : " . ($moyenne >= 10 ? 'ADMIS' : 'AJOURNÉ') . "</p>
                        </div>
                    </td>
                    <td>
                        <div class='signature-area'>
                            <p>Fait à Cotonou, le " . date('d/m/Y') . "</p>
                            <p style='text-decoration:underline; font-weight:bold;'>Le Directeur des Études</p>
                            <br><br><br>
                            <p style='font-size:10px; color:#999;'>Document généré électroniquement</p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </body>
    </html>";

    // 3. Rendu
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true); 

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    $dompdf->stream("Bulletin_" . $student['matricule'] . ".pdf", ["Attachment" => true]);

} catch (Exception $e) {
    die("Erreur Fatale : " . $e->getMessage());
}