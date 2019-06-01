<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

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
        $this->loadModel('Questions');
    }

    public function index() {
        $specialtyId = $this->request->getQuery('specialtyId', false);

        $tickets = $this->Tickets->find()
            ->contain([
                'Specialty',
                'Courses'
            ]);

        $connection = ConnectionManager::get('default');
        $pairs = $connection->execute(
            "SELECT tickets.id, COUNT(questions.id) as questions_count FROM `tickets`
            LEFT JOIN `questions` ON (questions.id_ticket = tickets.id)
            GROUP BY tickets.id
            "
        )
        ->fetchAll('assoc');

        if ($specialtyId && $specialtyId !== 'false') {
            $tickets
                ->where([
                    'Tickets.id_specialty' => $specialtyId
                ]);
        }

        $tickets = $tickets->toArray();

        foreach ($tickets as &$ticket) {
            foreach ($pairs as $pair) {
                if ($pair['id'] == $ticket['id']) {
                    $ticket['count_questions_marge'] = $pair['questions_count'];
                }
            }
        }

        return $this->Core->jsonResponse(true, null, [
            'tickets' => $tickets
        ]);
    }

    public function addTicket() {
        if ($this->request->is('POST')) {
            $params = $this->request->getData();
            $time = (int)$this->request->getData('time_of_passing', false);

            if ($time > 60) {
                return $this->Core->jsonResponse(false, 'Час проходення не може бути більший ніж 1 година!');
            }

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

            $newTicket['count_questions_marge'] = 0;

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

    public function updateTicket() {
        if ($this->request->is('POST')) {
            $id = $this->request->getData('id');

            if (!is_numeric($id)) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }

            try {
                $ticket = $this->Tickets->get($id);
            } catch (\Exception $e) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }

            $editTicket = $this->Tickets->patchEntity($ticket, $this->request->getData());

            if (!$this->Tickets->save($editTicket)) {
                return $this->Core->jsonResponse(false, $this->_parseEntityErrors($editTicket->getErrors()));
            }

            $getTicket = $this->Tickets->get($editTicket->id, [
                'contain' => [
                    'Specialty',
                    'Courses'
                ]
            ]);

            return $this->Core->jsonResponse(true, 'Білет оновлено', [
                'ticket' => $getTicket
            ]);
        }
    }
}
