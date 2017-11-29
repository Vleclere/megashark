<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Template Controller
 *
 *
 * @method \App\Model\Entity\Template[] paginate($object = null, array $settings = [])
 */
class TemplateController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $template = $this->paginate($this->Template);

        $this->set(compact('template'));
        $this->set('_serialize', ['template']);
    }

    /**
     * View method
     *
     * @param string|null $id Template id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $template = $this->Template->get($id, [
            'contain' => []
        ]);

        $this->set('template', $template);
        $this->set('_serialize', ['template']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $template = $this->Template->newEntity();
        if ($this->request->is('post')) {
            $template = $this->Template->patchEntity($template, $this->request->getData());
            if ($this->Template->save($template)) {
                $this->Flash->success(__('The template has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The template could not be saved. Please, try again.'));
        }
        $this->set(compact('template'));
        $this->set('_serialize', ['template']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Template id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $template = $this->Template->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $template = $this->Template->patchEntity($template, $this->request->getData());
            if ($this->Template->save($template)) {
                $this->Flash->success(__('The template has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The template could not be saved. Please, try again.'));
        }
        $this->set(compact('template'));
        $this->set('_serialize', ['template']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Template id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $template = $this->Template->get($id);
        if ($this->Template->delete($template)) {
            $this->Flash->success(__('The template has been deleted.'));
        } else {
            $this->Flash->error(__('The template could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
