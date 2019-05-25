<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

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
        $this->loadModel('Questions');
        $this->loadModel('Answers');

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
            $resTicket = [];

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

                $resTicket = $this->Tickets->get($entrantToTicket->id_ticket);
            } else {
                $connection = ConnectionManager::get('default');
                $sql = "
                    SELECT tickets.* FROM `tickets`
                    INNER JOIN `questions` ON (questions.id_ticket = tickets.id AND questions.is_full_answers = true)
                    WHERE tickets.is_progress = false AND tickets.id_specialty = $entrant->id_specialty
                    HAVING tickets.count_question = COUNT(questions.id)
                    ORDER BY tickets.id
                    LIMIT 1
                ";
                $ticket = $connection->execute($sql)
                    ->fetchAll('assoc');

                if (count($ticket) === 0) {
                    return $this->Core->jsonResponse(false, 'Білет не знайдено!');
                }

                $ticketId = (int)$ticket[0]['id'];

                $newRecordBind = $this->EntrantToTicket->newEntity();

                $newRecordBind->id_entrant = $entrant->id;
                $newRecordBind->id_ticket = $ticketId;

                if (!$this->EntrantToTicket->save($newRecordBind)) {
                    return $this->Core->jsonResponse(false, 'Connection error!');
                }

                $resTicket = $ticket[0];
            }

            return $this->Core->jsonResponse(true, 'Абітурієнт верифікований!', [
                'entrant' => $entrant,
                'ticket' => $resTicket
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

            $idTicket = $entrantToTicket->first()->id_ticket;

            $questions = $this->Questions->find()
                ->contain([
                    'Answers',
                    'Answers.Bundles'
                ])
                ->where([
                    'Questions.id_ticket' => $idTicket
                ])
                ->orderAsc('Questions.id_type')
                ->toArray();

            foreach ($questions as &$question) {
                if ($question->id_type === 3) {
                    $a_questions = [];
                    $a_answers = [];

                    foreach ($question->answers[0]->bundles as $bundle) {
                        array_push($a_questions, [
                            'id' => $bundle->id,
                            'title' => $bundle->a_question
                        ]);
                        array_push($a_answers, [
                            'id' => $bundle->id,
                            'title' => $bundle->a_answer
                        ]);
                    }

                    shuffle($a_questions);
                    shuffle($a_answers);

                    $question['move_bundles'] = [];

                    $question['move_bundles']['questions'] = $a_questions;
                    $question['move_bundles']['answers'] = $a_answers;

                    // delete bundles
                    unset($question->answers[0]->bundles);
                }
            }

            $ticket = $this->Tickets->get($idTicket);

            $editT = $this->Tickets->patchEntity($ticket, [
                'is_progress' => true
            ]);

            $this->Tickets->save($editT);

            return $this->Core->jsonResponse(true, 'success', [
                'questions' => $questions,
                'ticket' => $ticket
            ]);
        }
    }
}