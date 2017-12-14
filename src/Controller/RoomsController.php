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
        
        //On récupére le premier jours de la semaine et le dernier
        $startWeek = new Time(strtotime('monday this week'));
        $endWeek = new Time(strtotime('sunday this week'));
        
        //On sélectionne les séances correspondant à la salle et dans la semaine
        $selShow = $this->Rooms->Showtimes->find();
        $selShow->where(['room_id' => $id]);
        $selShow->where(['start >=' => $startWeek]);
        $selShow->where(['start <=' => $endWeek]);
        $selShow->order(['start']);
        
        $this->set('selShow', $selShow);
        $this->set('_serialize', ['selShow']);
        
        //On initialise le tableau contenant les séances
        $showtimesThisWeek = Array(
            "1" => array(),
            "2" => array(),
            "3" => array(),
            "4" => array(),
            "5" => array(),
            "6"=> array(),
            "7"=> array()
            );
        
        //On parcourt le tableau et on sélectionne chaque film dans cette salle
        foreach($selShow as $show)
        {
           $movies = $this->Rooms->Showtimes->Movies->find()
            ->where(['id' => $show->movie_id])
            ->first(); 
            $dateDebut = (new Time($show->start))->format('H:i');
            $dateFin = (new Time($show->end))->format('H:i');
            //On enregistre les données dans le tableau à la ligne correspondante
            $showtimesThisWeek[$show->start->format('N')][] = "$movies->name<br>$dateDebut / $dateFin<br>";
            
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
