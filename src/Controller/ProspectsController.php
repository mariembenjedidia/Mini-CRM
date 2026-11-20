<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class ProspectsController extends AppController
{
    private const STATUSES = [
        'new'         => 'Nouveau',
        'contacted'   => 'Contacté',
        'in_progress' => 'En cours',
        'client'      => 'Client',
        'lost'        => 'Perdu',
    ];

    private function getStats(): array
    {
        $stats = array_fill_keys(array_keys(self::STATUSES), 0);

        $results = $this->Prospects->find()
            ->select(['status', 'count' => 'COUNT(*)'])
            ->groupBy('status')
            ->enableHydration(false)
            ->all();

        foreach ($results as $row) {
            $s = strtolower((string)$row['status']);
            if (isset($stats[$s])) {
                $stats[$s] = (int)$row['count'];
            }
        }

        return $stats;
    }

    private function convertToClient($prospect): bool
    {
        $clientsTable = $this->fetchTable('Clients');

        $exists = $clientsTable->find()
            ->where(['prospect_id' => $prospect->id])
            ->first();

        if ($exists) {
            return true;
        }

        $client = $clientsTable->newEntity([
            'prospect_id'  => $prospect->id,
            'company_name' => $prospect->company_name,
            'contact_name' => $prospect->contact_name,
            'email'        => $prospect->email,
            'phone'        => $prospect->phone,
            'city'         => $prospect->city,
        ]);

        return (bool)$clientsTable->save($client);
    }
public function index()
{
    $query  = $this->Prospects->find()->contain(['Clients']);

    $search = $this->request->getQuery('search');
    $status = $this->request->getQuery('status');
    $sort   = $this->request->getQuery('sort');

    // 🔎 SEARCH
    if (!empty($search)) {
        $query->where([
            'OR' => [
                'Prospects.company_name LIKE' => '%' . $search . '%',
                'Prospects.contact_name LIKE' => '%' . $search . '%',
                'Prospects.email LIKE'        => '%' . $search . '%',
                'Prospects.city LIKE'         => '%' . $search . '%',
            ]
        ]);
    }

    // 🔽 STATUS
    if (!empty($status) && array_key_exists($status, self::STATUSES)) {
        $query->where(['Prospects.status' => $status]);
    }

    // 🔃 SORT
    if ($sort === 'asc') {
        $query->order(['Prospects.company_name' => 'ASC']);
    } elseif ($sort === 'desc') {
        $query->order(['Prospects.company_name' => 'DESC']);
    } else {
        $query->order(['Prospects.id' => 'DESC']);
    }

    // 📄 PAGINATION (ONLY ONCE)
    $prospects = $this->paginate($query, [
        'limit' => 10
    ]);

    // 📊 STATS
    $stats = $this->getStats();

    // 📤 SEND TO VIEW
    $this->set(compact(
        'prospects',
        'search',
        'status',
        'sort',
        'stats'
    ));

    $this->set('statuses', self::STATUSES);
}

    public function add()
    {
        $prospect = $this->Prospects->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if (!array_key_exists($data['status'] ?? '', self::STATUSES)) {
                $data['status'] = 'new';
            }

            $prospect = $this->Prospects->patchEntity($prospect, $data);

            if ($this->Prospects->save($prospect)) {
                if ($prospect->status === 'client') {
                    $this->convertToClient($prospect);
                    $this->Flash->success('Prospect ajouté et converti en client automatiquement.');
                } else {
                    $this->Flash->success('Prospect ajouté avec succès.');
                }
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('Erreur lors de l\'ajout.');
        }

        $this->set('statuses', self::STATUSES);
        $this->set(compact('prospect'));
    }

    public function edit($id = null)
    {
        $prospect  = $this->Prospects->get($id);
        $oldStatus = $prospect->status;

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();

            if (!array_key_exists($data['status'] ?? '', self::STATUSES)) {
                $data['status'] = $prospect->status;
            }

            $prospect = $this->Prospects->patchEntity($prospect, $data);

            if ($this->Prospects->save($prospect)) {
                if ($prospect->status === 'client' && $oldStatus !== 'client') {
                    $this->convertToClient($prospect);
                    $this->Flash->success('Prospect converti en client avec succès.');
                } else {
                    $this->Flash->success('Prospect modifié avec succès.');
                }
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('Erreur lors de la modification.');
        }

        $this->set('statuses', self::STATUSES);
        $this->set(compact('prospect'));
    }

    public function view($id = null)
    {
        if ($id === null) {
            throw new NotFoundException(__('Prospect introuvable.'));
        }

        $prospect = $this->Prospects->get($id, contain: ['Clients']);

        $this->set('statuses', self::STATUSES);
        $this->set(compact('prospect'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $prospect = $this->Prospects->get($id);

        if ($this->Prospects->delete($prospect)) {
            $this->Flash->success('Prospect supprimé.');
        } else {
            $this->Flash->error('Erreur lors de la suppression.');
        }

        return $this->redirect(['action' => 'index']);
    }

   public function export()
{
    $search = $this->request->getQuery('search');
    $status = $this->request->getQuery('status');
    $sort   = $this->request->getQuery('sort');

    $query = $this->Prospects->find();

    // Recherche
    if (!empty($search)) {
        $query->where([
            'OR' => [
                'company_name LIKE' => '%' . $search . '%',
                'contact_name LIKE' => '%' . $search . '%',
                'email LIKE'        => '%' . $search . '%',
                'phone LIKE'        => '%' . $search . '%',
                'city LIKE'         => '%' . $search . '%'
            ]
        ]);
    }

    // Filtre par statut
    if (!empty($status)) {
        $query->where([
            'status' => $status
        ]);
    }

    // Tri
    if ($sort === 'desc') {
        $query->order(['company_name' => 'DESC']);
    } else {
        $query->order(['company_name' => 'ASC']);
    }

    $prospects = $query->all();

    // Télécharger le CSV
    $this->response = $this->response
        ->withType('csv')
        ->withDownload('prospects.csv');

    $handle = fopen('php://temp', 'r+');

    // En-têtes
    fputcsv($handle, [
        'ID',
        'Entreprise',
        'Contact',
        'Email',
        'Téléphone',
        'Ville',
        'Statut'
    ]);

    // Données
    foreach ($prospects as $p) {
        fputcsv($handle, [
            $p->id,
            $p->company_name,
            $p->contact_name,
            $p->email,
            $p->phone,
            $p->city,
            $p->status
        ]);
    }

    rewind($handle);
    $csv = stream_get_contents($handle);
    fclose($handle);

    $this->response = $this->response->withStringBody($csv);

    return $this->response;
}
public function viewPdf($id = null)
{
    $this->request->allowMethod(['get']);

    $prospect = $this->Prospects->get($id);

    $s = strtolower((string)$prospect->status);
    $statuses = [
        'new'         => 'Nouveau',
        'contacted'   => 'Contacté',
        'in_progress' => 'En cours',
        'client'      => 'Client',
        'lost'        => 'Perdu',
    ];
    $libelle = $statuses[$s] ?? $prospect->status;

    $notes = !empty($prospect->notes)
        ? nl2br(htmlspecialchars($prospect->notes))
        : 'Aucune note';

    $refId = str_pad((string)$prospect->id, 4, '0', STR_PAD_LEFT);

    $html = '<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #333; margin: 40px; }
h1   { font-size: 20px; color: #1d4ed8; margin-bottom: 4px; }
.sub { font-size: 11px; color: #999; margin-bottom: 30px; }
hr   { border: none; border-top: 1px solid #e5e7eb; margin: 20px 0; }
table { width: 100%; border-collapse: collapse; }
td   { padding: 10px 12px; border-bottom: 1px solid #f0f0f0; font-size: 13px; }
td:first-child { width: 35%; color: #6b7280; font-weight: 600; font-size: 11px; text-transform: uppercase; }
.notes { background: #f9fafb; padding: 12px; border-left: 3px solid #1d4ed8; font-size: 13px; color: #374151; }
.footer { margin-top: 40px; font-size: 11px; color: #aaa; text-align: center; }
</style>
</head>
<body>

<h1>Fiche Prospect #' . $refId . '</h1>
<div class="sub">Généré le ' . date('d/m/Y à H:i') . ' — CRM Interne</div>

<hr>

<table>
    <tr><td>Entreprise</td>  <td>' . htmlspecialchars($prospect->company_name ?? '—') . '</td></tr>
    <tr><td>Contact</td>     <td>' . htmlspecialchars($prospect->contact_name ?? '—') . '</td></tr>
    <tr><td>Email</td>       <td>' . htmlspecialchars($prospect->email ?? '—') . '</td></tr>
    <tr><td>Téléphone</td>   <td>' . htmlspecialchars($prospect->phone ?? '—') . '</td></tr>
    <tr><td>Ville</td>       <td>' . htmlspecialchars($prospect->city ?? '—') . '</td></tr>
    <tr><td>Source</td>      <td>' . htmlspecialchars($prospect->source ?? '—') . '</td></tr>
    <tr><td>Statut</td>      <td>' . $libelle . '</td></tr>
</table>

<hr>

<div class="notes">' . $notes . '</div>

<div class="footer">CRM Interne — Prospect #' . $refId . '</div>

</body>
</html>';

    $options = new \Dompdf\Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', false);

    $dompdf = new \Dompdf\Dompdf($options);
    $dompdf->loadHtml($html, 'UTF-8');
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $filename = 'prospect_' . $refId . '_' . date('Ymd') . '.pdf';

    $this->response = $this->response
        ->withType('application/pdf')
        ->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
        ->withStringBody($dompdf->output());

    return $this->response;
}
}