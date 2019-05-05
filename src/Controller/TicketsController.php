<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Tickets Controller
 *
 * @property \App\Model\Table\TicketsTable $Tickets
 *
 * @method \App\Model\Entity\Ticket[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TicketsController extends AppController
{
    public function initialize() {
        parent::initialize();

        $this->loadModel('Tickets');
    }

    public function index() {
        $specialtyId = $this->request->getQuery('specialtyId', false);

        $tickets = $this->Tickets->find()
            ->contain([
                'Specialty',
                'Courses'
            ]);

        if ($specialtyId && $specialtyId !== 'false') {
            $tickets
                ->where([
                    'Tickets.id_specialty' => $specialtyId
                ]);
        }

        return $this->Core->jsonResponse(true, null, [
            'tickets' => $tickets
        ]);
    }

    public function addTicket() {
        if ($this->request->is('POST')) {
            $params = $this->request->getData();

            $isUniqueTitleSpicialty = !$this->Tickets->exists([
                'title' => $params['title'],
                'id_specialty' => $params['id_specialty']
            ]);

            if (!$isUniqueTitleSpicialty) {
                return $this->Core->jsonResponse(false, 'Білет з таким заголовком вже існує в даної спеціальності!');
            }

            $ticket = $this->Tickets->newEntity($params);

            if (!$this->Tickets->save($ticket)) {
                return $this->Core->jsonResponse(false, $this->_parseEntityErrors($ticket->getErrors()));
            }

            $newTicket = $this->Tickets->get($ticket->id, [
                'contain' => [
                    'Specialty',
                    'Courses'
                ]
            ]);

            return $this->Core->jsonResponse(true, 'Запит доданий!', [
                'ticket' => $newTicket
            ]);
        }
    }

    public function deleteTicket() {
        if ($this->request->is('POST')) {
            $id = $this->request->getData('id', false);

            if (!is_numeric($id)) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }

            try {
                $ticket = $this->Tickets->get($id);
            } catch (\Exception $e) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }

            if ($this->Tickets->delete($ticket)) {
                return $this->Core->jsonResponse(true, 'Білет видалено!');
            }
        }
    }
}
