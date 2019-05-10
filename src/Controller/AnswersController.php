<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Answers Controller
 *
 * @property \App\Model\Table\AnswersTable $Answers
 *
 * @method \App\Model\Entity\Answer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AnswersController extends AppController
{
    public function initialize() {
        parent::initialize();

        $this->loadModel('Answers');
        $this->loadModel('Questions');
    }

    public function searchHash() {
        $hash = $this->request->getQuery('hash', false);
        $answers = [];

        $question = $this->Questions->find()
            ->contain([
                'Tickets',
                'TypesQuestions'
            ])
            ->where([
                'search_hash' => $hash
            ])
            ->first();

        if (!empty($question)) {
            $answers = $this->Answers->find()
                ->where([
                    'id_question' => $question->id
                ])
                ->toArray();
        }

        return $this->Core->jsonResponse(true, 'success', [
            'question' => $question,
            'answers' => $answers
        ]);
    }

    public function addAnswer() {
        if ($this->request->is('POST')) {
            $params = $this->request->getData();

            $answer = $this->Answers->newEntity($params);

            if (!$this->Answers->save($answer)) {
                return $this->Core->jsonResponse(false, $this->_parseEntityErrors($answer->getErrors()));
            }

            return $this->Core->jsonResponse(true, 'Відповідь додана', [
                'answer' => $answer
            ]);
        }
    }

    public function deleteAnswer() {
        if ($this->request->is('POST')) {
            $id = $this->request->getData('id', false);

            if (!is_numeric($id)) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }

            try {
                $answer = $this->Answers->get($id);
            } catch (\Exception $e) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }

            if ($this->Answers->delete($answer)) {
                return $this->Core->jsonResponse(true, 'Відповідь видалено!');
            }
        }
    }

    public function updateAnswer() {
        if ($this->request->is('POST')) {
            $id = $this->request->getData('id' , false);

            if (!is_numeric($id)) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }

            try {
                $answer = $this->Answers->get($id);
            } catch (\Exception $e) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }

            $editAnswer = $this->Answers->patchEntity($answer, $this->request->getData());

            if (!$this->Answers->save($editAnswer)) {
                return $this->Core->jsonResponse(false, $this->_parseEntityErrors($editAnswer->getErrors()));
            }

            return $this->Core->jsonResponse(true, 'Відповідь оновлено', [
                'answer' => $editAnswer
            ]);
        }
    }
}
