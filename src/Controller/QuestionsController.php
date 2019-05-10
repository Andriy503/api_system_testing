<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\Folder;
use claviska\SimpleImage;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Questions Controller
 *
 * @property \App\Model\Table\QuestionsTable $Questions
 *
 * @method \App\Model\Entity\Question[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class QuestionsController extends AppController
{
    public function initialize() {
        parent::initialize();

        $this->loadModel('Questions');
    }

    public function getQuestions() {
        if ($this->request->is('GET')) {
            $ticketId = $this->request->getQuery('ticketId', false);

            if (!is_numeric($ticketId)) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }

            $questions = $this->Questions->find()
                ->where([
                    'id_ticket' => $ticketId
                ]);

            return $this->Core->jsonResponse(true, null, [
                'questions' => $questions
            ]);
        }
    }

    public function saveQuestion() {
        if ($this->request->is('POST')) {
            $imageFile = $this->request->getData('image', false);
            $fullPathImg = null;

            if ($imageFile !== false && is_array($imageFile) && !empty($imageFile)) {
                $resSaved = $this->_processSavedImage($imageFile);

                if (!$resSaved['success']) {
                    return $this->Core->jsonResponse(false, $resSaved['message']);
                }

                $fullPathImg = $resSaved['path'];
            }

            $params = $this->request->getData();
            $params['pre_img'] = $fullPathImg;
            $params['search_hash'] = uniqid('q', true); // generate unique hash

            $question = $this->Questions->newEntity($params);

            if (!$this->Questions->save($question)) {
                return $this->Core->jsonResponse(false, $this->_parseEntityErrors($question->getErrors()));
            }

            $newQuestion = $this->Questions->get($question->id);

            return $this->Core->jsonResponse(true, 'Питання додано!', [
                'question' => $newQuestion
            ]);
        }
    }

    public function deleteQuestion() {
        if ($this->request->is('POST')) {
            $id = $this->request->getData('id', false);

            if (!is_numeric($id)) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }

            try {
                $question = $this->Questions->get($id);
            } catch (\Exception $e) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }

            if ($this->Questions->delete($question)) {
                return $this->Core->jsonResponse(true, 'Питання видалено!');
            }
        }
    }

    public function editQuestion() {
        if ($this->request->is('POST')) {
            $imageFile = $this->request->getData('image', false);
            $params = $this->request->getData();
            $id = $params['id'];

            if (!is_numeric($id)) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }

            try {
                $question = $this->Questions->get($id);
            } catch (\Exception $e) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }

            if ($imageFile !== false && is_array($imageFile) && !empty($imageFile)) {
                $resSaved = $this->_processSavedImage($imageFile);

                if (!$resSaved['success']) {
                    return $this->Core->jsonResponse(false, $resSaved['message']);
                }

                $params['pre_img'] = $resSaved['path'];
            }

            if (isset($params['pre_img']) && $params['pre_img'] === 'null') {
                $params['pre_img'] = null;
            }

            $editQuestion = $this->Questions->patchEntity($question, $params);

            if (!$this->Questions->save($editQuestion)) {
                return $this->Core->jsonResponse(false, $this->_parseEntityErrors($editQuestion->getErrors()));
            }

            $getQuestion = $this->Questions->get($editQuestion->id);

            return $this->Core->jsonResponse(true, 'Питання оновлено', [
                'question' => $getQuestion
            ]);
        }
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
        $folderPath = 'upload' . DS . 'questions-images';

        (new Folder($rootPath . $folderPath, true));

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
