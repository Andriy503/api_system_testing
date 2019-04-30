<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Cpecialty Controller
 *
 *
 * @method \App\Model\Entity\Cpecialty[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SpecialtyController extends AppController
{
    public function initialize() {
        parent::initialize();

        $this->loadModel('Specialty');
        $this->loadModel('Tickets');
    }

    public function getSpecialtyForIdDepartament() {
        $departamentId = $this->request->getData('departamentId');

        $specialtys = $this->Specialty->find()
            ->contain('Departaments')
            ->where([
                'Specialty.id_departament' => $departamentId
            ])
            ->all();

        return $this->Core->jsonResponse(true, null, [
            'specialtys' => $specialtys
        ]);
    }

    public function addSpecialty() {
        $title = $this->request->getData('title');
        $short_title = $this->request->getData('short_title');
        $full_name = $this->request->getData('full_name');
        $id_departament = $this->request->getData('id_departament');

        if (empty($title) || !is_numeric($id_departament)) {
            return $this->Core->jsonResponse(false, 'Заповніть коректно форму!');
        }

        $specialty = $this->Specialty->newEntity();

        $specialty->title = $title;
        $specialty->short_title = (!empty($short_title) ? $short_title : null);
        $specialty->full_name = (!empty($full_name) ? $full_name : null);
        $specialty->id_departament = $id_departament;


        if ($this->Specialty->save($specialty)) {
            return $this->Core->jsonResponse(true, 'Запит доданий!');
        }

        return $this->Core->jsonResponse(false, 'Помилка сервера!');
    }

    public function editSpecialty() {
        $params = $this->request->getData();

        if (!is_numeric($params['id'])){
            return $this->Core->jsonResponse(false, 'Connection Error');
        }

        $specialty = $this->Specialty->get($params['id']);

        $editSpecialty = $this->Specialty->patchEntity($specialty, $params);

        if ($this->Specialty->save($editSpecialty)) {
            return $this->Core->jsonResponse(true, ' Спеціальність оновлено!');
        }

        return $this->Core->jsonResponse(false, 'Помилка сервера!');
    }

    public function deleteSpecialty() {
        $id = $this->request->getData('id');

        if (!is_numeric($id)) {
            return $this->Core->jsonResponse(false, 'Connection Error');
        }

        $specialty = $this->Specialty->get($id);

        $this->Tickets->updateAll(
            [
                'id_specialty' => NULL
            ],
            [
                'id_specialty' => $specialty->id
            ]
        );

        if ($this->Specialty->delete($specialty)) {
            return $this->Core->jsonResponse(true, 'Спеціальність видалено!');
        }

        return $this->Core->jsonResponse(false, 'Помилка сервера!');
    }
}
