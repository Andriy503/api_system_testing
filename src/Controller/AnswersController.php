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
        $this->loadModel('Bundles');
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
                ->contain('Bundles')
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

            $this->checkingFullingQuestion($idQuestion);

            return $this->Core->jsonResponse(true, 'Відповідь додано', [
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
                $this->checkingFullingQuestion($answer->id_question);

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

    public function addBundles() {
        if ($this->request->is('POST')) {
            $data = $this->request->getData('data', false);
            $id_question = $this->request->getData('id_question', false);

            $answer = $this->Answers->newEntity([
                'id_question' => $id_question,
                'title' => ''
            ]);

            if (!is_numeric($id_question) || !$data || !is_array($data)) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }

            if (!$this->Answers->save($answer)) {
                return $this->Core->jsonResponse(false, $this->_parseEntityErrors($answer->getErrors()));
            }

            foreach ($data as $item) {
                $newBundle = $this->Bundles->newEntity(
                    array_merge($item, [
                        'id_answer' => $answer->id
                    ])
                );

                if (!$this->Bundles->save($newBundle)) {
                    return $this->Core->jsonResponse(false, $this->_parseEntityErrors($newBundle->getErrors()));
                }
            }

            $this->checkingFullingQuestion($id_question);

            return $this->Core->jsonResponse(true, 'Асоціації додані!');
        }
    }

    public function updateBundle() {
        if ($this->request->is('POST')) {
            $data = $this->request->getData('data', false);

            if (!is_array($data)) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }

            foreach ($data as $item) {
                try {
                    $bundle = $this->Bundles->get($item['id']);
                } catch (\Exception $e) {
                    return $this->Core->jsonResponse(false, 'Connection Error');
                }

                $updateBundle = $this->Bundles->patchEntity($bundle, $item);

                if (!$this->Bundles->save($updateBundle)) {
                    return $this->Core->jsonResponse(false, $this->_parseEntityErrors($updateBundle->getErrors()));
                }
            }

            return $this->Core->jsonResponse(true, 'Асоціації оновлено');
        }
    }

    private function checkingFullingQuestion($idQuestion) {
        try {
            $question = $this->Questions->get($idQuestion, [
                'contain' => [
                    'Answers'
                ]
            ]);
        } catch (\Exception $e) {
            return $this->Core->jsonResponse(false, 'Connection Error');
        }

        $typeId = $question->id_type;
        $isFullAnswers = false;

        switch ($typeId) {
            case 1:
                if (count($question->answers) === 4) {
                    $isFullAnswers = true;
                }
                break;

            case 2:
                if (count($question->answers) === 4) {
                    $isFullAnswers = true;
                }
                break;

            case 3:
                if (count($question->answers) === 1) {
                    $isFullAnswers = true;
                }
                break;

            case 4:
                if (count($question->answers) === 1) {
                    $isFullAnswers = true;
                }
                break;
        }

        $editQuestionFulling = $this->Questions->patchEntity(
            $this->Questions->get($idQuestion),
            [
                'is_full_answers' => $isFullAnswers
            ]
        );

        $this->Questions->save($editQuestionFulling);
    }
}
