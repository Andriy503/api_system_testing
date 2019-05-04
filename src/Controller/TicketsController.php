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
        $tickets = $this->Tickets->find()
            ->contain([
                'Specialty',
                'Courses'
            ]);

        return $this->Core->jsonResponse(true, null, [
            'tickets' => $tickets
        ]);
    }
}
