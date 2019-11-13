<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\Folder;
use claviska\SimpleImage;

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
            $preImg = $this->request->getData('pre_img', false);

            $params['current_answer'] = ($params['current_answer'] === '1') ? true : false;

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

            if ($preImg) {
                $resultSavedImage = $this->_processavedImage($preImg, 'answers-images');

                if (!$resultSavedImage['success']) {
                    return $this->Core->jsonResponse(false, $resultSavedImage['message']);
                }

                $answer['pre_img'] = $resultSavedImage['path']; // save page answer
            }

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
            $id_question = $this->request->getData('id_question', false);
            $assoc = json_decode($this->request->getData('data', []));
            $images = $this->request->getData(); unset($images['data']); unset($images['id_question']);

            if (!is_numeric($id_question)) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }

            $validAssoc = [];
            foreach($assoc as $index => $item) {
                $fields = [];
                $fields['a_question'] = $item->a_question;
                $fields['a_answer'] = $item->a_answer;

                if (isset($images['q_pre_img_' . $index])) {
                    $resSaved = $this->_processSavedImage($images['q_pre_img_' . $index]);

                    if (!$resSaved['success']) {
                        return $this->Core->jsonResponse(false, $resSaved['message']);
                    }

                    $fields['q_pre_img'] = $resSaved['path'];
                }

                if (isset($images['a_pre_img_' . $index])) {
                    $resSaved = $this->_processSavedImage($images['a_pre_img_' . $index]);

                    if (!$resSaved['success']) {
                        return $this->Core->jsonResponse(false, $resSaved['message']);
                    }

                    $fields['a_pre_img'] = $resSaved['path'];
                }


                array_push($validAssoc, $fields);
            }

            $answer = $this->Answers->newEntity([
                'id_question' => $id_question,
                'title' => ''
            ]);

            if (!$this->Answers->save($answer)) {
                return $this->Core->jsonResponse(false, $this->_parseEntityErrors($answer->getErrors()));
            }

            foreach ($validAssoc as $item) {
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

            return $this->Core->jsonResponse(true, 'Асоціації додано!');
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

    private function _processavedImage($imageFile, $folderName) {
        if ($imageFile['error'] !== UPLOAD_ERR_OK) {
            return [
                'success' => false,
                'message' => 'Не вдалося завантажити зображення!'
            ];
        }

        if ($imageFile['size'] > 2048 * 1024) {
            return [
                'success' => false,
                'message' => 'Розмір зображення має бути менше 2Мб'
            ];
        }

        $extension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
        if (!in_array(strtolower($extension), ['png', 'jpg', 'jpeg'], true)) {
            return [
                'success' => false,
                'message' => 'Неправильне розширення зображення потрібно .jpg або .png або .jpeg'
            ];
        }

        $rootPath = WWW_ROOT;
        $folderPath = 'upload' . DS . $folderName;

        (new Folder($rootPath . $folderPath, true)); // create folder

        $fileName = uniqid("", true) . '.' . strtolower($extension);

        try {
            $image = new SimpleImage();

            $image
                ->fromFile($imageFile['tmp_name'])
                // ->resize(400, 300)
                ->toFile($folderPath . DS . $fileName, 'image/jpeg', 85);

            $exif = $image->getExif();

        } catch (\Exception $err) {
            return [
                'success' => false,
                'message' => $err->getMessage()
            ];
        }

        $fullPathImg = DS . $folderPath . DS . $fileName;

        return [
            'success' => true,
            'message' => null,
            'path' => $fullPathImg
        ];
    }

    public function multipleSavedImages() {
        $field = $this->request->getData('field', false);
        $bundleId = $this->request->getData('bundle_id', false);
        $image = $this->request->getData('image', false);
        $id_question = $this->request->getData('id_question', false);
        $data = [];

        if ($image) {
            $resultSavedImage = $this->_processavedImage($image, 'bundles-images');

            if (!$resultSavedImage['success']) {
                return $this->Core->jsonResponse(false, $resultSavedImage['message']);
            }

            $data[$field . '_pre_img'] = $resultSavedImage['path']; // save page answer
        }

        if ($bundleId) { // update
            $bundle = $this->Bundles->get($bundleId);

            $updateBunble = $this->Bundles->patchEntity($bundle, $data);

            if (!$this->Bundles->save($updateBunble)) {
                return $this->Core->jsonResponse(false, 'Помилка сервера!');
            }
        } else { // add
            $answer = $this->Answers->newEntity([
                'id_question' => $id_question,
                'title' => ''
            ]);

            if (!$this->Answers->save($answer)) {
                return $this->Core->jsonResponse(false, $this->_parseEntityErrors($answer->getErrors()));
            }

            $data['id_answer'] = $answer->id;

            $newBundle = $this->Bundles->newEntity($data);

            if (!$this->Bundles->save($newBundle)) {
                return $this->Core->jsonResponse(false, $this->_parseEntityErrors($newBundle->getErrors()));
            }
        }

        return $this->Core->jsonResponse(true, 'Зображення додано!');
    }

    private function _processSavedImage($imageFile) {
        if ($imageFile['error'] !== UPLOAD_ERR_OK) {
            return [
                'success' => false,
                'message' => 'Не вдалося завантажити зображення!'
            ];
        }

        if ($imageFile['size'] > 2048 * 1024) {
            return [
                'success' => false,
                'message' => 'Розмір зображення має бути менше 2Мб'
            ];
        }

        $extension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
        if (!in_array(strtolower($extension), ['png', 'jpg', 'jpeg'], true)) {
            return [
                'success' => false,
                'message' => 'Неправильне розширення зображення потрібно .jpg або .png або .jpeg'
            ];
        }

        $rootPath = WWW_ROOT;
        $folderPath = 'upload' . DS . 'bundles-images';

        (new Folder($rootPath . $folderPath, true)); // create folder

        $fileName = uniqid("", true) . '.' . strtolower($extension);

        try {
            $image = new SimpleImage();

            $image
                ->fromFile($imageFile['tmp_name'])
                // ->resize(400, 300)
                ->toFile($folderPath . DS . $fileName, 'image/jpeg', 85);

            $exif = $image->getExif();

        } catch (\Exception $err) {
            return [
                'success' => false,
                'message' => $err->getMessage()
            ];
        }

        $fullPathImg = DS . $folderPath . DS . $fileName;

        return [
            'success' => true,
            'message' => null,
            'path' => $fullPathImg
        ];
    }
}
