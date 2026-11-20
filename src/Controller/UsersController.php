<?php
declare(strict_types=1);

namespace App\Controller;

class UsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->addUnauthenticatedActions([
            'login',
            'add'
        ]);
    }

    /* ================= LOGIN ================= */
    public function login()
    {
        $this->viewBuilder()->setLayout('login');

        $this->request->allowMethod(['get', 'post']);

        $result = $this->Authentication->getResult();

        if ($result && $result->isValid()) {
            return $this->redirect(
                $this->Authentication->getLoginRedirect()
                ?? ['controller' => 'Prospects', 'action' => 'index']
            );
        }

        if ($this->request->is('post') && $result && !$result->isValid()) {
            $this->Flash->error('Email ou mot de passe incorrect');
        }
    }

    /* ================= LOGOUT ================= */
    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['action' => 'login']);
    }

    /* ================= REGISTER ================= */
    public function add()
    {
        $this->viewBuilder()->setLayout('login');

        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success('Account created successfully');
                return $this->redirect(['action' => 'login']);
            }

            $this->Flash->error('The user could not be saved');
        }

        $this->set(compact('user'));
    }

    /* ================= PROFILE ================= */
    public function profile()
    {
        $identity = $this->request->getAttribute('identity');

        if (!$identity) {
            return $this->redirect(['action' => 'login']);
        }

        $userData = $this->Users->get($identity->id);
        $this->set(compact('userData'));
    }

    /* ================= ADMIN INDEX ================= */
    public function index()
    {
        $identity = $this->request->getAttribute('identity');

        if (!$identity || $identity->role !== 'admin') {
            $this->Flash->error('Accès refusé.');
            return $this->redirect(['action' => 'profile']);
        }

        $search = $this->request->getQuery('search');
        $role   = $this->request->getQuery('role');

        $query = $this->Users->find();

        if (!empty($search)) {
            $query->where([
                'OR' => [
                    'firstname LIKE' => '%' . $search . '%',
                    'lastname LIKE'  => '%' . $search . '%',
                    'email LIKE'     => '%' . $search . '%',
                ]
            ]);
        }

        if (!empty($role)) {
            $query->where(['role' => $role]);
        }

        $query->orderBy(['Users.id' => 'DESC']);

        $users = $this->paginate($query);

        $this->set(compact('users', 'search', 'role'));
    }

    /* ================= VIEW ================= */
    public function view($id = null)
    {
        $identity = $this->request->getAttribute('identity');

        if (!$identity || $identity->role !== 'admin') {
            return $this->redirect(['action' => 'profile']);
        }

        $user = $this->Users->get($id);
        $this->set(compact('user'));
    }

    /* ================= EDIT ================= */
    public function edit($id = null)
    {
        $identity = $this->request->getAttribute('identity');

        if (!$identity ) {
            return $this->redirect(['action' => 'profile']);
        }

        $user = $this->Users->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success('User updated');
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('Update failed');
        }

        $this->set(compact('user'));
    }

    /* ================= DELETE ================= */
    public function delete($id = null)
    {
        $identity = $this->request->getAttribute('identity');

        if (!$identity || $identity->role !== 'admin') {
            return $this->redirect(['action' => 'profile']);
        }

        $this->request->allowMethod(['post', 'delete']);

        $user = $this->Users->get($id);

        if ($this->Users->delete($user)) {
            $this->Flash->success('User deleted');
        } else {
            $this->Flash->error('Delete failed');
        }

        return $this->redirect(['action' => 'index']);
    }
    public function viewPdf($id = null)
{
    $user = $this->Users->get($id);
    $html = '
    <html>
    <head>
        <meta charset="utf-8">
        <style>
            body { font-family: DejaVu Sans, sans-serif; color: #111827; font-size: 13px; }
            .header { border-bottom: 2px solid #1d4ed8; padding-bottom: 12px; margin-bottom: 20px; }
            .header h1 { color: #1d4ed8; font-size: 20px; margin: 0; }
            .header p { color: #6b7280; font-size: 11px; margin: 4px 0 0; }
            table { width: 100%; border-collapse: collapse; margin-top: 10px; }
            td { padding: 8px 10px; border-bottom: 1px solid #e5e7eb; }
            td.label { width: 35%; color: #6b7280; font-weight: bold; text-transform: uppercase; font-size: 10px; }
            td.value { color: #111827; font-size: 13px; }
            .badge { display: inline-block; padding: 3px 10px; border-radius: 10px; font-size: 11px; font-weight: bold; }
            .b-admin { background: #fee2e2; color: #991b1b; }
            .b-user { background: #dcfce7; color: #166534; }
            .footer { margin-top: 30px; font-size: 10px; color: #9ca3af; text-align: center; }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>Fiche Utilisateur</h1>
            <p>CRM Pro &mdash; Genere le ' . date('d/m/Y a H:i') . '</p>
        </div>
        <table>
            <tr>
                <td class="label">ID</td>
                <td class="value">#' . h((string)$user->id) . '</td>
            </tr>
            <tr>
                <td class="label">Nom complet</td>
                <td class="value">' . h($user->firstname . ' ' . $user->lastname) . '</td>
            </tr>
            <tr>
                <td class="label">Email</td>
                <td class="value">' . h($user->email) . '</td>
            </tr>
            <tr>
                <td class="label">Role</td>
                <td class="value">
                    <span class="badge ' . ($user->role === 'admin' ? 'b-admin' : 'b-user') . '">' .
                        h(ucfirst($user->role)) . '</span>
                </td>
            </tr>
            <tr>
                <td class="label">Date de creation</td>
                <td class="value">' . h($user->created->format('d/m/Y a H:i')) . '</td>
            </tr>
        </table>
        <div class="footer">
            Document genere automatiquement par CRM Pro
        </div>
    </body>
    </html>';
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->loadHtml($html);
    $dompdf->render();
    $filename = 'utilisateur_' . $user->id . '_' . date('Ymd') . '.pdf';
    $this->response = $this->response
        ->withType('pdf')
        ->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
        ->withStringBody($dompdf->output());
    return $this->response;
}
}