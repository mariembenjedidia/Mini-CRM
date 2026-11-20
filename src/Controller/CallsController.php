<?php
declare(strict_types=1);

namespace App\Controller;

class CallsController extends AppController
{
    public function index()
    {
        $search = $this->request->getQuery('search');
        $sort   = $this->request->getQuery('sort');

        $query = $this->Calls->find()->contain(['Prospects']);

        if (!empty($search)) {
            $query->where([
                'OR' => [
                    'subject LIKE'                => '%' . $search . '%',
                    'Prospects.company_name LIKE' => '%' . $search . '%',
                ],
            ]);
        }

        if (in_array($sort, ['asc', 'desc'], true)) {
            $query->order(['call_date' => $sort]);
        }

        $this->paginate = ['limit' => 10];
        $calls = $this->paginate($query);

        $this->set(compact('calls', 'search', 'sort'));
    }

    public function view($id = null)
    {
        $call = $this->Calls->get($id, contain: ['Prospects']);
        $this->set(compact('call'));
    }

    public function add()
    {
        $call = $this->Calls->newEmptyEntity();

        if ($this->request->is('post')) {
            $call = $this->Calls->patchEntity($call, $this->request->getData());
            if ($this->Calls->save($call)) {
                $this->Flash->success('Appel ajouté avec succès.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Erreur lors de l\'ajout.');
        }

        $prospects = $this->Calls->Prospects->find('list', limit: 200)->all();
        $this->set(compact('call', 'prospects'));
    }

    public function edit($id = null)
    {
        $call = $this->Calls->get($id, contain: []);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $call = $this->Calls->patchEntity($call, $this->request->getData());
            if ($this->Calls->save($call)) {
                $this->Flash->success('Appel modifié avec succès.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Erreur lors de la modification.');
        }

        $prospects = $this->Calls->Prospects->find('list', limit: 200)->all();
        $this->set(compact('call', 'prospects'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $call = $this->Calls->get($id);

        if ($this->Calls->delete($call)) {
            $this->Flash->success('Appel supprimé.');
        } else {
            $this->Flash->error('Erreur lors de la suppression.');
        }

        return $this->redirect(['action' => 'index']);
    }

    public function export()
    {
        $search = $this->request->getQuery('search');
        $sort   = $this->request->getQuery('sort');

        $query = $this->Calls->find()->contain(['Prospects']);

        if (!empty($search)) {
            $query->where([
                'OR' => [
                    'subject LIKE'                => '%' . $search . '%',
                    'Prospects.company_name LIKE' => '%' . $search . '%',
                ],
            ]);
        }

        if (in_array($sort, ['asc', 'desc'], true)) {
            $query->order(['call_date' => $sort]);
        }

        $calls = $query->all();

        $this->response = $this->response
            ->withType('csv')
            ->withDownload('appels_' . date('Y-m-d') . '.csv');

        $handle = fopen('php://temp', 'r+');

        fputcsv($handle, ['ID', 'Prospect', 'Date appel', 'Sujet', 'Commentaire', 'Prochain appel']);

        foreach ($calls as $c) {
            fputcsv($handle, [
                $c->id,
                $c->prospect->company_name ?? '—',
                $c->call_date?->format('d/m/Y H:i') ?? '—',
                $c->subject ?? '—',
                $c->comment ?? '—',
                $c->next_call_date?->format('d/m/Y H:i') ?? '—',
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

        $call = $this->Calls->get($id, contain: ['Prospects']);

        $refId = str_pad((string)$call->id, 4, '0', STR_PAD_LEFT);

        $prospect      = $call->prospect ?? null;
        $companyName   = htmlspecialchars($prospect->company_name ?? '—');
        $contactName   = htmlspecialchars($prospect->contact_name ?? '—');
        $prospectEmail = htmlspecialchars($prospect->email ?? '—');
        $prospectPhone = htmlspecialchars($prospect->phone ?? '—');

        $callDate     = $call->call_date?->format('d/m/Y à H:i') ?? '—';
        $nextCallDate = $call->next_call_date?->format('d/m/Y à H:i') ?? '—';
        $subject      = htmlspecialchars($call->subject ?? '—');
        $comment      = !empty($call->comment)
            ? nl2br(htmlspecialchars($call->comment))
            : '<em style="color:#9ca3af;">Aucun commentaire</em>';

        $html = '<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #333; margin: 40px; }
h1   { font-size: 20px; color: #16a34a; margin-bottom: 4px; }
.sub { font-size: 11px; color: #999; margin-bottom: 30px; }
hr   { border: none; border-top: 1px solid #e5e7eb; margin: 20px 0; }
.section-title {
    font-size: 11px; text-transform: uppercase; letter-spacing: .08em;
    color: #16a34a; font-weight: 700; margin: 20px 0 10px;
    padding-bottom: 5px; border-bottom: 2px solid #bbf7d0;
}
table { width: 100%; border-collapse: collapse; }
td { padding: 9px 12px; border-bottom: 1px solid #f0f0f0; font-size: 13px; }
td:first-child {
    width: 35%; color: #6b7280; font-weight: 600;
    font-size: 11px; text-transform: uppercase; background: #f9fafb;
}
tr:nth-child(even) td { background: #f9fafb; }
tr:nth-child(even) td:first-child { background: #f3f4f6; }
.comment-box {
    background: #f9fafb; padding: 12px 14px;
    border-left: 3px solid #16a34a;
    font-size: 13px; color: #374151; line-height: 1.6;
    min-height: 50px;
}
.footer { margin-top: 50px; font-size: 11px; color: #aaa; text-align: center; }
</style>
</head>
<body>

<h1>Fiche Appel #' . $refId . '</h1>
<div class="sub">Généré le ' . date('d/m/Y à H:i') . ' — CRM Interne</div>

<hr>

<div class="section-title">Informations de l\'appel</div>
<table>
    <tr><td>Référence</td>      <td>#' . $refId . '</td></tr>
    <tr><td>Date de l\'appel</td> <td>' . $callDate . '</td></tr>
    <tr><td>Sujet</td>          <td>' . $subject . '</td></tr>
    <tr><td>Prochain appel</td> <td>' . $nextCallDate . '</td></tr>
</table>

<div class="section-title">Prospect associé</div>
<table>
    <tr><td>Entreprise</td> <td>' . $companyName . '</td></tr>
    <tr><td>Contact</td>    <td>' . $contactName . '</td></tr>
    <tr><td>Email</td>      <td>' . $prospectEmail . '</td></tr>
    <tr><td>Téléphone</td>  <td>' . $prospectPhone . '</td></tr>
</table>

<div class="section-title">Commentaire</div>
<div class="comment-box">' . $comment . '</div>

<div class="footer">CRM Interne — Appel #' . $refId . ' — Généré le ' . date('d/m/Y à H:i') . '</div>

</body>
</html>';

        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', false);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'appel_' . $refId . '_' . date('Ymd') . '.pdf';

        $this->response = $this->response
            ->withType('application/pdf')
            ->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->withStringBody($dompdf->output());

        return $this->response;
    }
}