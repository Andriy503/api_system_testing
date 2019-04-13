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

    public function test() {
        $tickets = $this->Tickets->find()
            ->contain([
                'Specialty',
                'Courses'
            ])
            ->all();

        return $this->Core->jsonResponse(true, null, [
            'tickets' => $tickets
        ]);
    }
}
