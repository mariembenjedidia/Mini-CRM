<!-- templates/Dashboard/index.php -->

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h3 mb-0 text-gray-800">Tableau de Bord</h1>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row">
        <!-- Total prospects -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2"
                 style="cursor:pointer"
                 onclick="window.location='<?= $this->Url->build(['controller' => 'Prospects', 'action' => 'index']) ?>'">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Nombre total de prospects
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalProspects ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total clients -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2"
                 style="cursor:pointer"
                 onclick="window.location='<?= $this->Url->build(['controller' => 'Clients', 'action' => 'index']) ?>'">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Nombre de clients
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalClients ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-briefcase fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prospects ce mois -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2"
                 style="cursor:pointer"
                 onclick="window.location='<?= $this->Url->build(['controller' => 'Prospects', 'action' => 'index']) ?>'">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Prospects ajoutés ce mois
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $prospectsMonth ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-person-plus fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Appels ce mois -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2"
                 style="cursor:pointer"
                 onclick="window.location='<?= $this->Url->build(['controller' => 'Calls', 'action' => 'index']) ?>'">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Appels effectués ce mois
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $callsMonth ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-telephone fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="row">
        <!-- Répartition des statuts -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Répartition des statuts</h6>
                    <select id="selectStatus" class="form-select form-select-sm" style="width:110px;">
                        <?php for ($year = date('Y'); $year >= 2020; $year--) : ?>
                            <option value="<?= $year ?>" <?= $year == date('Y') ? 'selected' : '' ?>>
                                <?= $year ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Evolution des prospects -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Evolution des prospects</h6>
                    <select id="selectEvolution" class="form-select form-select-sm" style="width:110px;">
                        <?php for ($year = date('Y'); $year >= 2020; $year--) : ?>
                            <option value="<?= $year ?>" <?= $year == date('Y') ? 'selected' : '' ?>>
                                <?= $year ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="evolutionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.font.family = 'Nunito,-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.color = '#858796';

    const months = ['Jan','Fév','Mar','Avr','Mai','Juin','Juil','Août','Sept','Oct','Nov','Déc'];
    const CHART_DATA_URL = '<?= $this->Url->build(['controller' => 'Dashboard', 'action' => 'chartData']) ?>';

    // Ordre fixe des statuts
    const STATUS_ORDER = ['Nouveau', 'Contacté', 'En cours', 'Client', 'Perdu'];
    const STATUS_COLORS = {
        'Nouveau':  '#4e73df',
        'Contacté': '#36b9cc',
        'En cours': '#f6c23e',
        'Client':   '#1cc88a',
        'Perdu':    '#e74a3b',
    };
    const STATUS_HOVER = {
        'Nouveau':  '#2e59d9',
        'Contacté': '#2c9faf',
        'En cours': '#dda20a',
        'Client':   '#17a673',
        'Perdu':    '#be2617',
    };

    // ── Status Chart ──────────────────────────────────────────────
    const statusChart = new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: STATUS_ORDER,
            datasets: [{
                data: [0, 0, 0, 0, 0],
                backgroundColor: STATUS_ORDER.map(s => STATUS_COLORS[s]),
                hoverBackgroundColor: STATUS_ORDER.map(s => STATUS_HOVER[s]),
                hoverBorderColor: 'rgba(234,236,244,1)',
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { display: true, position: 'bottom' } },
            cutout: '70%',
        }
    });

    // ── Evolution Chart ───────────────────────────────────────────
    const evolutionChart = new Chart(document.getElementById('evolutionChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Prospects',
                lineTension: 0.3,
                backgroundColor: 'rgba(78,115,223,0.05)',
                borderColor: 'rgba(78,115,223,1)',
                pointRadius: 3,
                pointBackgroundColor: 'rgba(78,115,223,1)',
                pointBorderColor: 'rgba(78,115,223,1)',
                pointHoverRadius: 3,
                pointHoverBackgroundColor: 'rgba(78,115,223,1)',
                pointHoverBorderColor: 'rgba(78,115,223,1)',
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: Array(12).fill(0),
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                x: {
                    grid: { display: false, drawBorder: false },
                    ticks: { maxTicksLimit: 7 }
                },
                y: {
                    ticks: { maxTicksLimit: 5, padding: 10 },
                    grid: { color: 'rgb(234,236,244)', drawBorder: false, borderDash: [2] }
                }
            },
            plugins: { legend: { display: false } }
        }
    });

    // ── Fetch helpers ─────────────────────────────────────────────
    async function loadStatusChart(year) {
        try {
            const res  = await fetch(`${CHART_DATA_URL}?year=${year}`);
            const json = await res.json();
            const raw  = json.statusCounts ?? [];

            // Mapper dans l'ordre fixe, 0 si absent
            const data = STATUS_ORDER.map(label => {
                const entry = raw.find(d => d.status === label);
                return entry ? parseInt(entry.count) : 0;
            });

            statusChart.data.datasets[0].data = data;
            statusChart.update();
        } catch (e) {
            console.error('Erreur chargement statuts:', e);
        }
    }

    async function loadEvolutionChart(year) {
        try {
            const res  = await fetch(`${CHART_DATA_URL}?year=${year}`);
            const json = await res.json();
            const raw  = json.prospectEvolution ?? [];

            const full = Array.from({ length: 12 }, (_, i) => {
                const entry = raw.find(d => parseInt(d.month) === i + 1);
                return entry ? parseInt(entry.count) : 0;
            });

            evolutionChart.data.datasets[0].data = full;
            evolutionChart.update();
        } catch (e) {
            console.error('Erreur chargement évolution:', e);
        }
    }

    // ── Chargement initial ────────────────────────────────────────
    const currentYear = new Date().getFullYear();
    loadStatusChart(currentYear);
    loadEvolutionChart(currentYear);

    // ── Events ────────────────────────────────────────────────────
    document.getElementById('selectStatus').addEventListener('change', e => loadStatusChart(e.target.value));
    document.getElementById('selectEvolution').addEventListener('change', e => loadEvolutionChart(e.target.value));
</script>

<style>
    .border-left-primary { border-left: .25rem solid #4e73df !important; }
    .border-left-success { border-left: .25rem solid #1cc88a !important; }
    .border-left-info    { border-left: .25rem solid #36b9cc !important; }
    .border-left-warning { border-left: .25rem solid #f6c23e !important; }
    .text-xs    { font-size: .7rem; }
    .chart-pie  { height: 300px; }
    .chart-area { height: 300px; }
    .card { transition: all .2s ease; }
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
    }
</style>