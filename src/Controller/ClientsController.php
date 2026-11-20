<?php
declare(strict_types=1);

namespace App\Controller;

class ClientsController extends AppController
{
    public function index()
    {
        $search = $this->request->getQuery('search');
        $sort   = $this->request->getQuery('sort');

        $query = $this->Clients->find();

        if (!empty($search)) {
            $query->where([
                'OR' => [
                    'company_name LIKE' => '%' . $search . '%',
                    'contact_name LIKE' => '%' . $search . '%',
                    'email LIKE'        => '%' . $search . '%',
                    'city LIKE'         => '%' . $search . '%',
                ],
            ]);
        }

        if (in_array($sort, ['asc', 'desc'], true)) {
            $query->order(['company_name' => $sort]);
        }

        $this->paginate = ['limit' => 10];
        $clients = $this->paginate($query);

        $this->set(compact('clients', 'search', 'sort'));
    }

    public function view($id = null)
    {
        $client = $this->Clients->get($id, contain: ['Prospects']);
        $this->set(compact('client'));
    }

    public function add()
    {
        $client = $this->Clients->newEmptyEntity();

        if ($this->request->is('post')) {
            $client = $this->Clients->patchEntity($client, $this->request->getData());

            if ($this->Clients->save($client)) {
                $this->Flash->success('Client ajouté avec succès.');
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('Impossible d\'ajouter le client.');
        }

        $prospects = $this->Clients->Prospects->find('list', ['limit' => 200])->all();
        $this->set(compact('client', 'prospects'));
    }

    public function edit($id = null)
    {
        $client = $this->Clients->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $client = $this->Clients->patchEntity($client, $this->request->getData());

            if ($this->Clients->save($client)) {
                $this->Flash->success('Client modifié avec succès.');
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('Impossible de modifier le client.');
        }

        $prospects = $this->Clients->Prospects->find('list', ['limit' => 200])->all();
        $this->set(compact('client', 'prospects'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $client = $this->Clients->get($id);

        if ($this->Clients->delete($client)) {
            $this->Flash->success('Client supprimé.');
        } else {
            $this->Flash->error('Impossible de supprimer le client.');
        }

        return $this->redirect(['action' => 'index']);
    }

    public function export()
    {
        $search = $this->request->getQuery('search');
        $sort   = $this->request->getQuery('sort');

        $query = $this->Clients->find();

        if (!empty($search)) {
            $query->where([
                'OR' => [
                    'company_name LIKE' => '%' . $search . '%',
                    'contact_name LIKE' => '%' . $search . '%',
                    'email LIKE'        => '%' . $search . '%',
                    'city LIKE'         => '%' . $search . '%',
                ],
            ]);
        }

        if (in_array($sort, ['asc', 'desc'], true)) {
            $query->order(['company_name' => $sort]);
        }

        $clients = $query->all();

        $this->response = $this->response
            ->withType('csv')
            ->withDownload('clients_' . date('Y-m-d') . '.csv');

        $handle = fopen('php://temp', 'r+');

        fputcsv($handle, ['ID', 'Entreprise', 'Contact', 'Email', 'Téléphone', 'Ville']);

        foreach ($clients as $c) {
            fputcsv($handle, [
                $c->id,
                $c->company_name ?? '—',
                $c->contact_name ?? '—',
                $c->email        ?? '—',
                $c->phone        ?? '—',
                $c->city         ?? '—',
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

        $client = $this->Clients->get($id, contain: ['Prospects']);

        $refId = str_pad((string)$client->id, 4, '0', STR_PAD_LEFT);

        $companyName = htmlspecialchars($client->company_name ?? '—');
        $contactName = htmlspecialchars($client->contact_name ?? '—');
        $email       = htmlspecialchars($client->email        ?? '—');
        $phone       = htmlspecialchars($client->phone        ?? '—');
        $city        = htmlspecialchars($client->city         ?? '—');

        // Infos prospect d'origine
        $prospect        = $client->prospect ?? null;
        $prospectRef     = $prospect ? '#' . str_pad((string)$prospect->id, 4, '0', STR_PAD_LEFT) : '—';
        $prospectSource  = htmlspecialchars($prospect->source ?? '—');
        $prospectNotes   = !empty($prospect->notes)
            ? nl2br(htmlspecialchars($prospect->notes))
            : '<em style="color:#9ca3af;">Aucune note</em>';

        $html = '<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #333; margin: 40px; }
h1   { font-size: 20px; color: #1d4ed8; margin-bottom: 4px; }
.sub { font-size: 11px; color: #999; margin-bottom: 30px; }
hr   { border: none; border-top: 1px solid #e5e7eb; margin: 20px 0; }
.section-title {
    font-size: 11px; text-transform: uppercase; letter-spacing: .08em;
    color: #1d4ed8; font-weight: 700; margin: 20px 0 10px;
    padding-bottom: 5px; border-bottom: 2px solid #dbeafe;
}
table { width: 100%; border-collapse: collapse; }
td { padding: 9px 12px; border-bottom: 1px solid #f0f0f0; font-size: 13px; }
td:first-child {
    width: 35%; color: #6b7280; font-weight: 600;
    font-size: 11px; text-transform: uppercase; background: #f9fafb;
}
tr:nth-child(even) td { background: #f9fafb; }
tr:nth-child(even) td:first-child { background: #f3f4f6; }
.notes-box {
    background: #f9fafb; padding: 12px 14px;
    border-left: 3px solid #1d4ed8;
    font-size: 13px; color: #374151; line-height: 1.6;
    min-height: 50px;
}
.badge-client {
    display: inline-block; padding: 4px 14px;
    border-radius: 999px; font-size: 11px; font-weight: 700;
    background: #dcfce7; color: #166534;
}
.footer { margin-top: 50px; font-size: 11px; color: #aaa; text-align: center; }
</style>
</head>
<body>

<h1>Fiche Client #' . $refId . '</h1>
<div class="sub">Généré le ' . date('d/m/Y à H:i') . ' — CRM Interne</div>

<hr>

<div class="section-title">Informations client</div>
<table>
    <tr><td>Référence</td>  <td>#' . $refId . '</td></tr>
    <tr><td>Entreprise</td> <td>' . $companyName . '</td></tr>
    <tr><td>Contact</td>    <td>' . $contactName . '</td></tr>
    <tr><td>Email</td>      <td>' . $email . '</td></tr>
    <tr><td>Téléphone</td>  <td>' . $phone . '</td></tr>
    <tr><td>Ville</td>      <td>' . $city . '</td></tr>
    <tr><td>Statut</td>     <td><span class="badge-client">Client</span></td></tr>
</table>

<div class="section-title">Prospect d\'origine</div>
<table>
    <tr><td>Référence prospect</td> <td>' . $prospectRef . '</td></tr>
    <tr><td>Source</td>             <td>' . $prospectSource . '</td></tr>
</table>

<div class="section-title">Notes</div>
<div class="notes-box">' . $prospectNotes . '</div>

<div class="footer">CRM Interne — Client #' . $refId . ' — Généré le ' . date('d/m/Y à H:i') . '</div>

</body>
</html>';

        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', false);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'client_' . $refId . '_' . date('Ymd') . '.pdf';

        $this->response = $this->response
            ->withType('application/pdf')
            ->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->withStringBody($dompdf->output());

        return $this->response;
    }
}