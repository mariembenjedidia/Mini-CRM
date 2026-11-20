<?php
declare(strict_types=1);

namespace App\Controller;

class DashboardController extends AppController
{
    private array $statusLabels = [
        'new'         => 'Nouveau',
        'contacted'   => 'Contacté',
        'in_progress' => 'En cours',
        'client'      => 'Client',
        'lost'        => 'Perdu',
    ];

    public function index(): void
    {
        

    
        $prospectsTable = $this->fetchTable('Prospects');
        $clientsTable   = $this->fetchTable('Clients');
        $callsTable     = $this->fetchTable('Calls');

        $currentMonth = (int)date('m');
        $currentYear  = (int)date('Y');

        $totalProspects = $prospectsTable->find()->count();
        $totalClients   = $clientsTable->find()->count();

        $prospectsMonth = $prospectsTable->find()
            ->where([
                'MONTH(created)' => $currentMonth,
                'YEAR(created)'  => $currentYear,
            ])
            ->count();

        $callsMonth = $callsTable->find()
            ->where([
                'MONTH(call_date)' => $currentMonth,
                'YEAR(call_date)'  => $currentYear,
            ])
            ->count();

        $rawStatus = $prospectsTable->find()
            ->select(['status', 'count' => 'COUNT(*)'])
            ->where(['YEAR(created)' => $currentYear])
            ->groupBy('status')
            ->enableHydration(false)
            ->toArray();

        $statusCounts = array_map(function ($row) {
            $row['status'] = $this->statusLabels[$row['status']] ?? $row['status'];
            return $row;
        }, $rawStatus);

        $prospectEvolution = $prospectsTable->find()
            ->select(['month' => 'MONTH(created)', 'count' => 'COUNT(*)'])
            ->where(['YEAR(created)' => $currentYear])
            ->groupBy('MONTH(created)')
            ->orderBy(['MONTH(created)' => 'ASC'])
            ->enableHydration(false)
            ->toArray();

        $this->set(compact(
            'totalProspects',
            'totalClients',
            'prospectsMonth',
            'callsMonth',
            'statusCounts',
            'prospectEvolution'
        ));
    }

    public function chartData(): void
    {
        $this->request->allowMethod(['get']);
        $year = (int)($this->request->getQuery('year') ?? date('Y'));

        $prospectsTable = $this->fetchTable('Prospects');

        $rawStatus = $prospectsTable->find()
            ->select(['status', 'count' => 'COUNT(*)'])
            ->where(['YEAR(created)' => $year])
            ->groupBy('status')
            ->enableHydration(false)
            ->toArray();

        $statusCounts = array_map(function ($row) {
            $row['status'] = $this->statusLabels[$row['status']] ?? $row['status'];
            return $row;
        }, $rawStatus);

        $prospectEvolution = $prospectsTable->find()
            ->select(['month' => 'MONTH(created)', 'count' => 'COUNT(*)'])
            ->where(['YEAR(created)' => $year])
            ->groupBy('MONTH(created)')
            ->orderBy(['MONTH(created)' => 'ASC'])
            ->enableHydration(false)
            ->toArray();

        $this->viewBuilder()->setClassName('Json');
        $this->set(compact('statusCounts', 'prospectEvolution'));
        $this->viewBuilder()->setOption('serialize', ['statusCounts', 'prospectEvolution']);
    }
}