<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Entrants Controller
 *
 *
 * @method \App\Model\Entity\Entrant[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EntrantsController extends AppController
{
    public function initialize() {
        parent::initialize();

        $this->loadModel('Entrants');
    }

    public function getEntrants() {
        $entrants = $this->Entrants->find()
            ->contain('Specialty')
            ->each(function($i) {
                if ($i->age) {
                    $i->age = $i->age->format('Y-m-d');
                }
            });

        return $this->Core->jsonResponse(true, 'success', [
            'entrants' => $entrants
        ]);
    }

    public function addEntrant() {
        if ($this->request->is('POST')) {
            $params = $this->request->getData();

            $entrant = $this->Entrants->newEntity($params);

            if (!$this->Entrants->save($entrant)) {
                return $this->Core->jsonResponse(false, $this->_parseEntityErrors($entrant->getErrors()));
            }

            try {
                $newEntrant = $this->Entrants->get($entrant->id, [
                    'contain' => [
                        'Specialty'
                    ]
                ]);
            } catch (\Exception $e) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }

            $newEntrant->age = $newEntrant->age->format('Y-m-d');

            return $this->Core->jsonResponse(true, 'Абітурієнта додано!', [
                'entrant' => $newEntrant
            ]);
        }
    }

    public function updateEntrant() {
        if ($this->request->is('POST')) {
            $params = $this->request->getData();

            if (!is_numeric($params['id'])) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }

            try {
                $entrant = $this->Entrants->get($params['id']);
            } catch (\Exception $e) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }

            $updateEntrant = $this->Entrants->patchEntity($entrant, $params);

            if (!$this->Entrants->save($updateEntrant)) {
                return $this->Core->jsonResponse(false, $this->_parseEntityErrors($updateEntrant->getErrors()));
            }

            try {
                $editEntrant = $this->Entrants->get($updateEntrant->id, [
                    'contain' => [
                        'Specialty'
                    ]
                ]);
            } catch (\Exception $e) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }

            $editEntrant->age = $editEntrant->age->format('Y-m-d');

            return $this->Core->jsonResponse(true, 'Дані оновлено', [
                'entrant' => $editEntrant
            ]);
        }
    }

    public function deleteEntrant() {
        if ($this->request->is('POST')) {
            $id = $this->request->getData('id', false);

            if (!is_numeric($id)) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }

            try {
                $entrant = $this->Entrants->get($id);
            } catch (\Exception $e) {
                return $this->Core->jsonResponse(false, 'Connection Error');
            }

            if ($this->Entrants->delete($entrant)) {
                return $this->Core->jsonResponse(true, 'Абітурієнта видалено!');
            }
        }
    }
}
