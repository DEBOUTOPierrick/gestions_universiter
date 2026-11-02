<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Programme Mensuel | ISMT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-grad: linear-gradient(135deg, #8a1e3b 0%, #d30819 100%);
            --accent: #ef4444;
            --bg-light: #f1f5f9;
            --glass: rgba(255, 255, 255, 0.9);
        }

        body { 
            background: var(--bg-light); 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: #1e293b;
        }

        /* EN-TETE STYLE "PREMIUM" */
        .header-section {
            background: var(--primary-grad);
            padding: 40px 0 80px 0; /* Plus d'espace en bas pour l'effet de chevauchement */
            color: white;
            border-bottom-left-radius: 40px;
            border-bottom-right-radius: 40px;
            box-shadow: 0 10px 30px rgba(30, 58, 138, 0.2);
            margin-bottom: -50px; /* Fait remonter le contenu suivant */
        }

        .btn-dashboard {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: white;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-dashboard:hover {
            background: white;
            color: #1e3a8a;
            transform: translateY(-2px);
        }

        /* CONTENU PRINCIPAL */
        .main-content {
            position: relative;
            z-index: 10;
        }

        .month-nav {
            background: white;
            border-radius: 20px;
            padding: 15px 25px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        /* CALENDRIER */
        .calendar-grid {
            background: white;
            padding: 25px;
            border-radius: 24px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 12px;
        }

        .calendar-day-head {
            text-align: center;
            font-weight: 800;
            color: #64748b;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .calendar-cell {
            aspect-ratio: 1 / 1;
            border-radius: 16px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            transition: all 0.2s ease;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .calendar-cell:hover {
            background: #eff6ff;
            border-color: #3b82f6;
            transform: scale(1.05);
        }

        .calendar-cell.active {
            background: var(--primary-grad);
            color: white;
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
        }

        .calendar-cell.has-event {
            position: relative;
        }

        .calendar-cell.has-event::after {
            content: '';
            position: absolute;
            bottom: 8px;
            width: 5px;
            height: 5px;
            background: var(--accent);
            border-radius: 50%;
        }

        /* LISTE DES COURS */
        .event-list {
            background: white;
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        }

        .course-card {
            background: #f8fafc;
            border-radius: 18px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 6px solid #3b82f6;
            transition: transform 0.2s;
        }

        .course-card:hover {
            transform: translateX(5px);
        }

        @media (max-width: 768px) {
            .header-section { border-radius: 0 0 25px 25px; padding: 30px 0 60px 0; }
            .calendar-grid { gap: 6px; padding: 15px; }
        }
    </style>
</head>
<body>

<header class="header-section">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="fw-800 mb-1" style="letter-spacing: -1px;">Mon Planning</h1>
                <p class="opacity-75 mb-0">Institut Supérieur de Management et de Technologie</p>
            </div>
            <a href="tableau_de_bord.php" class="btn btn-dashboard">
                <i class="bi bi-grid-1x2-fill me-2"></i> Mon Profil
            </a>
        </div>
    </div>
</header>

<main class="container main-content">
    <div class="month-nav">
        <button class="btn btn-light btn-sm rounded-circle"><i class="bi bi-chevron-left"></i></button>
        <h4 class="fw-bold mb-0">Février 2026</h4>
        <button class="btn btn-light btn-sm rounded-circle"><i class="bi bi-chevron-right"></i></button>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="calendar-grid">
                <div class="calendar-day-head">Lun</div>
                <div class="calendar-day-head">Mar</div>
                <div class="calendar-day-head">Mer</div>
                <div class="calendar-day-head">Jeu</div>
                <div class="calendar-day-head">Ven</div>
                <div class="calendar-day-head">Sam</div>
                <div class="calendar-day-head">Dim</div>

                <div class="calendar-cell text-muted opacity-25">26</div>
                <div class="calendar-cell text-muted opacity-25">27</div>
                <div class="calendar-cell text-muted opacity-25">28</div>
                <div class="calendar-cell text-muted opacity-25">29</div>
                <div class="calendar-cell text-muted opacity-25">30</div>
                <div class="calendar-cell text-muted opacity-25">31</div>
                
                <div class="calendar-cell active">1</div>
                <div class="calendar-cell has-event">2</div>
                <div class="calendar-cell">3</div>
                <div class="calendar-cell has-event">4</div>
                <div class="calendar-cell">5</div>
                <div class="calendar-cell has-event">6</div>
                <div class="calendar-cell">7</div>
                <div class="calendar-cell">8</div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="event-list">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary text-white rounded-3 p-2 me-3">
                        <i class="bi bi-calendar3"></i>
                    </div>
                    <h5 class="fw-bold mb-0">Lundi 2 Février</h5>
                </div>
                
                <div class="course-card">
                    <span class="badge bg-soft-primary text-primary mb-2" style="background: #e0e7ff;">08:30 - 10:30</span>
                    <h6 class="fw-bold mb-1">Analyse Mathématique</h6>
                    <p class="small text-muted mb-0"><i class="bi bi-person-circle me-1"></i> Dr. Kouassi | Salle 302</p>
                </div>

                <div class="course-card" style="border-left-color: #10b981;">
                    <span class="badge mb-2" style="background: #d1fae5; color: #059669;">11:00 - 13:00</span>
                    <h6 class="fw-bold mb-1">Architecture des Ordis</h6>
                    <p class="small text-muted mb-0"><i class="bi bi-laptop me-1"></i> Labo Info A</p>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>