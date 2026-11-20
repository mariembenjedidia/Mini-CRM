<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Crm Controller
 *
 */
class CrmController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Crm->find();
        $crm = $this->paginate($query);

        $this->set(compact('crm'));
    }

    /**
     * View method
     *
     * @param string|null $id Crm id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $crmEntity = $this->Crm->get($id, contain: []);
        $this->set(compact('crmEntity'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $crmEntity = $this->Crm->newEmptyEntity();
        if ($this->request->is('post')) {
            $crmEntity = $this->Crm->patchEntity($crmEntity, $this->request->getData());
            if ($this->Crm->save($crmEntity)) {
                $this->Flash->success(__('The crm has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The crm could not be saved. Please, try again.'));
        }
        $this->set(compact('crmEntity'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Crm id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $crmEntity = $this->Crm->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $crmEntity = $this->Crm->patchEntity($crmEntity, $this->request->getData());
            if ($this->Crm->save($crmEntity)) {
                $this->Flash->success(__('The crm has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The crm could not be saved. Please, try again.'));
        }
        $this->set(compact('crmEntity'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Crm id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $crmEntity = $this->Crm->get($id);
        if ($this->Crm->delete($crmEntity)) {
            $this->Flash->success(__('The crm has been deleted.'));
        } else {
            $this->Flash->error(__('The crm could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
