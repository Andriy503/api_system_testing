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
            $idQuestion = $this->request->getData('id_question', false);

            try {
                $question = $this->Questions->get($idQuestion);
            } catch (\Exception $e) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }

            $checkRootAddAnswer = $this->_cheketRootAnswerType($question, $params);

            if (!$checkRootAddAnswer['success']) {
                return $this->Core->jsonResponse(false, $checkRootAddAnswer['message']);
            }

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

    private function _cheketRootAnswerType($question, $preAnswer) {
        $associations = [
            1 => '_oneAnswer',
            2 => '_manyAnswers',
            3 => '',
            4 => '_wordAnswer'
        ];

        $result = call_user_func_array(
            // name function
            [
                $this,
                $associations[$question->id_type]
            ],
            // params
            [
                $question,
                $preAnswer
            ]
        );

        return $result;
    }

    private function _oneAnswer($question, $preAnswer) {
        $answers = $this->Answers->find()
            ->where([
                'id_question' => $question->id
            ])
            ->toArray();

        // check count answer
        if (count($answers) >= 4) {
            return [
                'success' => false,
                'message' => 'Питання не може містити більше ніж 4 відповіді!'
            ];
        }

        // check current answer true
        if ($preAnswer['current_answer']) {
            $current_answers = array_column($answers, 'current_answer');

            if (in_array(true, $current_answers)) {
                return [
                    'success' => false,
                    'message' => 'Питання не може мати більше ніж 1 правильну відповідь!'
                ];
            }
        }

        return [
            'success' => true
        ];
    }

    private function _manyAnswers($question, $preAnswer) {
        $answers = $this->Answers->find()
            ->where([
                'id_question' => $question->id
            ])
            ->toArray();

        // check count answer
        if (count($answers) >= 4) {
            return [
                'success' => false,
                'message' => 'Питання не може містити більше ніж 4 відповіді!'
            ];
        }

        return [
            'success' => true
        ];
    }

    private function _wordAnswer($question, $preAnswer) {
        $answers = $this->Answers->find()
            ->where([
                'id_question' => $question->id
            ])
            ->toArray();

        // check count answer
        if (count($answers) >= 1) {
            return [
                'success' => false,
                'message' => 'Питання не може містити більше ніж 1 відповідь!'
            ];
        }

        return [
            'success' => true
        ];
    }
}
