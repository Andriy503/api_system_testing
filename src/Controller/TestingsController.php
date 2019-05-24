<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Testings Controller
 *
 *
 * @method \App\Model\Entity\Testing[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TestingsController extends AppController
{
    public function initialize() {
        parent::initialize();

        $this->loadModel('Entrants');
        $this->loadModel('EntrantToTicket');
        $this->loadModel('Tickets');

        $this->Auth->allow(
            [
                'verificationEntrant',
                'getDataAndCheckRootUser'
            ]
        );
    }

    public function verificationEntrant() {
        if ($this->request->is('POST')) {
            $params = (object)$this->request->getData();

            $entrant = $this->Entrants->find()
                ->contain('Specialty')
                ->where([
                    'first_name' => $params->first_name,
                    'last_name' => $params->last_name,
                    'age' => $params->age
                ])
                ->first();

            if (empty($entrant)) {
                return $this->Core->jsonResponse(false, 'Абітурієнта не знайдено!');
            }

            if ($entrant->is_passed) {
                return $this->Core->jsonResponse(false, 'Даний абірурієнт уже проходив тестування!');
            }

            $entrantToTicket = $this->EntrantToTicket->find()
                ->contain('Tickets')
                ->where([
                    'id_entrant' => $entrant->id
                ])
                ->first();

            if (!empty($entrantToTicket)) {
                if ($entrantToTicket->is_done) {
                    return $this->Core->jsonResponse('Абітурієнт уже проходив тестування!');
                }
            } else {
                $ticket = $this->Tickets->find()
                    ->contain('Questions')
                    ->where([
                        'Tickets.is_progress' => false,
                        'Tickets.id_specialty' => $entrant->id_specialty
                    ])
                    ->first();
                // тут потрібно витянути білет тобто питання і відповіді!

                var_dump($ticket);
            }

            return;

            return $this->Core->jsonResponse(true, 'Абітурієнт верифікований!', [
                'entrant' => $entrant
            ]);
        }
    }

    public function getDataAndCheckRootUser() {
        if ($this->request->is('POST')) {
            $idEntrant = $this->request->getData('id', false);

            if (empty($idEntrant) || !is_numeric($idEntrant)) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }

            try {
                $entrant = $this->Entrants->get($idEntrant);
            } catch (\Exception $e) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }


            $entrantToTicket = $this->EntrantToTicket->find()
                ->contain('Tickets')
                ->where([
                    'id_entrant' => $entrant->id
                ]);

            if ($entrantToTicket->isEmpty()) {
                return $this->Core->jsonResponse(false, 'Білет не прив\'язаний до абітурієнта!');
            }

            // the need pull all questions and answers

            return $this->Core->jsonResponse(true, 'success', [
                'entrant' => $entrant,
                'entrantToTicket' => $entrantToTicket
            ]);
        }
    }
}
