<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * Rooms Controller
 *
 *
 * @method \App\Model\Entity\Room[] paginate($object = null, array $settings = [])
 */
class RoomsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $rooms = $this->paginate($this->Rooms);
        
        $this->set(compact('rooms'));
        $this->set('_serialize', ['rooms']);
    }

    /**
     * View method
     *
     * @param string|null $id Room id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $room = $this->Rooms->get($id, [
            'contain' => []
        ]);

        $this->set('room', $room);
        $this->set('_serialize', ['room']);
        
        $startWeek = new Time(strtotime('monday this week'));
        $endWeek = new Time(strtotime('sunday this week'));
        
        $selShow = $this->Rooms->Showtimes->find();
        $selShow->where(['room_id' => $id]);
        $selShow->where(['start >=' => $startWeek]);
        $selShow->where(['start <=' => $endWeek]);
        
        $this->set('selShow', $selShow);
        $this->set('_serialize', ['selShow']);
        
        $showtimesThisWeek = Array(
            "1" => "",
            "2" => "",
            "3" => "",
            "4" => "",
            "5" => "",
            "6"=> "",
            "7"=> ""
            );
        
        foreach($selShow as $show)
        {
           $movies = $this->Rooms->Showtimes->Movies->find()
            ->where(['id' => $show->movie_id]); 
            $nom = $movies->name;
            $dateDebut = (new Time($show->start))->format('Y-m-d H:i:s');
            $dateFin = (new Time($show->end))->format('Y-m-d H:i:s');
            $showtimesThisWeek[$show->start->format('N')] = "Film : $nom<br>Debut : $dateDebut<br>Fin : $dateFin<br>";
            
        }
        
        $this->set('showtimesThisWeek', $showtimesThisWeek);
        $this->set('_serialize', ['showtimesThisWeek']);
        
        
        
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $room = $this->Rooms->newEntity();
        if ($this->request->is('post')) {
            $room = $this->Rooms->patchEntity($room, $this->request->getData());
            if ($this->Rooms->save($room)) {
                $this->Flash->success(__('The room has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The room could not be saved. Please, try again.'));
        }
        $this->set(compact('room'));
        $this->set('_serialize', ['room']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Room id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $room = $this->Rooms->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $room = $this->Rooms->patchEntity($room, $this->request->getData());
            if ($this->Rooms->save($room)) {
                $this->Flash->success(__('The room has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The room could not be saved. Please, try again.'));
        }
        $this->set(compact('room'));
        $this->set('_serialize', ['room']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Room id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $room = $this->Rooms->get($id);
        if ($this->Rooms->delete($room)) {
            $this->Flash->success(__('The room has been deleted.'));
        } else {
            $this->Flash->error(__('The room could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
