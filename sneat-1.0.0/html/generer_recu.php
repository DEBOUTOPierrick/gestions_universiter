<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Impression Reçu - ISMT SERVICES</title>
    <style>
        /* Style spécifique pour l'impression */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .receipt-container {
            width: 180mm; /* Largeur idéale pour A5 ou papier lettre */
            margin: auto;
            background: #fff;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
        }

        /* En-tête */
        .header {
            display: flex;
            justify-content: space-between;
            border-bottom: 2px solid #696cff;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .logo-area h1 {
            color: #696cff;
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }

        .receipt-info {
            text-align: right;
        }

        .receipt-title {
            text-align: center;
            text-transform: uppercase;
            background: #f0f2ff;
            padding: 10px;
            margin: 20px 0;
            font-weight: bold;
            letter-spacing: 2px;
        }

        /* Corps du reçu */
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .details-table td {
            padding: 12px 5px;
            border-bottom: 1px solid #f0f0f0;
        }

        .label {
            color: #666;
            width: 30%;
            font-weight: 600;
        }

        .value {
            color: #333;
            font-weight: bold;
        }

        .amount-box {
            background: #696cff;
            color: #fff;
            padding: 15px;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            border-radius: 5px;
            margin: 20px 0;
        }

        /* Zone de signature */
        .signature-area {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }

        .sig-box {
            width: 40%;
            text-align: center;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
            font-size: 14px;
        }

        /* Bouton d'impression (caché à l'impression) */
        .no-print {
            text-align: center;
            margin-bottom: 20px;
        }

        .btn-print {
            background: #696cff;
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        @media print {
            .no-print { display: none; }
            body { background: white; padding: 0; }
            .receipt-container { box-shadow: none; border: none; width: 100%; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button class="btn-print" onclick="window.print()">🖨️ LANCER L'IMPRESSION</button>
        <p><small>Le reçu s'ouvrira proprement sur le papier.</small></p>
    </div>

    <div class="receipt-container">
        <div class="header">
            <div class="logo-area">
                <h1>ISMT SERVICES</h1>
                <small>Institut Supérieur de Management et de Technologie</small><br>
                <small>Godomey, Bénin | Tél: +229 XX XX XX XX</small>
            </div>
            <div class="receipt-info">
                <div style="font-size: 18px; font-weight: bold; color: #696cff;">REÇU N° REC-5D3F2</div>
                <div>Date : 18/04/2026</div>
                <div>Heure : 14:35</div>
            </div>
        </div>

        <div class="receipt-title">REÇU DE PAIEMENT</div>

        <table class="details-table">
            <tr>
                <td class="label">Reçu de :</td>
                <td class="value text-uppercase">ADAMOU Moussa</td>
            </tr>
            <tr>
                <td class="label">Matricule :</td>
                <td class="value">ISMT-2026-M1-GL</td>
            </tr>
            <tr>
                <td class="label">Motif :</td>
                <td class="value">Scolarité (2ème Tranche) - Master 1 Génie Logiciel</td>
            </tr>
            <tr>
                <td class="label">Mode de paiement :</td>
                <td class="value">ESPECES (Guichet)</td>
            </tr>
            <tr>
                <td class="label">Année Scolaire :</td>
                <td class="value">2025-2026</td>
            </tr>
        </table>

        <div class="amount-box">
            MONTANT : 150.000 FCFA
        </div>
        
        <p style="font-style: italic; font-size: 13px; text-align: center;">
            Arrêté le présent reçu à la somme de : <b>Cent cinquante mille Francs CFA</b>
        </p>

        <div class="signature-area">
            <div class="sig-box">
                L'Étudiant<br><br><br>
                <small>(Signature)</small>
            </div>
            <div class="sig-box">
                Le Caissier / L'Économe<br><br><br>
                <small>(Nom & Cachet)</small>
            </div>
        </div>

        <div style="margin-top: 40px; text-align: center; font-size: 10px; color: #aaa; border-top: 1px solid #eee; padding-top: 10px;">
            ISMT SERVICES - Logiciel de gestion académique v2.0 - Reçu généré numériquement.
        </div>
    </div>

</body>
</html>