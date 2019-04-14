<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Educations Controller
 *
 *
 * @method \App\Model\Entity\Education[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EducationsController extends AppController
{
    public function initialize () {
        parent::initialize();

        $this->loadModel('EducationalSubdivisions');
        $this->loadModel('Departaments');
        $this->loadModel('Specialty');

        $this->Auth->allow(['getEducations']);
    }

    // get Educations
    public function getEducations() {
        $educations = $this->EducationalSubdivisions->find()->all();
        $departaments = $this->Departaments->find()->all();

        return $this->Core->jsonResponse(true, null, [
            'educations' => $educations,
            'departaments' => $departaments
        ]);
    }

    public function addEducation() {
        $title = $this->request->getData('title');

        if (empty($title)) {
            return $this->Core->jsonResponse(false, 'Connection Error');
        }

        $education = $this->EducationalSubdivisions->newEntity();

        $education->title = $title;

        if ($this->EducationalSubdivisions->save($education)) {
            return $this->Core->jsonResponse(true, 'Запит доданий!', [
                'education' => $education
            ]);
        }

        return $this->Core->jsonResponse(false, 'Помилка сервера!');
    }

    public function updateEducation() {
        $id = $this->request->getData('id');
        $title = $this->request->getData('title');

        if (!is_numeric($id) || empty($title)) {
            return $this->Core->jsonResponse(false, 'Connection Error');
        }

        $education = $this->EducationalSubdivisions->get($id);

        $editEducation = $this->EducationalSubdivisions->patchEntity($education, [
            'title' => $title
        ]);

        if ($this->EducationalSubdivisions->save($editEducation)) {
            return $this->Core->jsonResponse(true, 'Навчальний підрозділ оновлено!', [
                'education' => $education
            ]);
        }

        return $this->Core->jsonResponse(false, 'Помилка сервера!');
    }

    public function deleteEducation() {
        $id = $this->request->getData('id');

        if (!is_numeric($id)) {
            return $this->Core->jsonResponse(false, 'Connection Error');
        }

        $education = $this->EducationalSubdivisions->get($id);

        $departamentsIds = $this->Departaments->find()
            ->where([
                'id_educations' => $education->id
            ])
            ->map(function ($row) {
                return $row->id;
            })
            ->toArray();

        //  delete all specialty
        $this->Specialty->deleteAll([
            'id_departament IN' => $departamentsIds
        ]);

        // delete all departamet
        $this->Departaments->deleteAll([
            'id_educations' => $education->id
        ]);

        // delete education
        if ($this->EducationalSubdivisions->delete($education)) {
            return $this->Core->jsonResponse(true, 'Навчальний підрозділ видалено!', [
                'educations' => $this->EducationalSubdivisions->find()->all()
            ]);
        }

        return $this->Core->jsonResponse(false, 'Помилка сервера!');
    }

    public function getFixedDepartaments() {
        $educationId = $this->request->getQuery('educationId');

        $education = $this->EducationalSubdivisions->find()
            ->where([
                'id' => $educationId
            ]);

        if ($education->isEmpty()) {
            return $this->Core->jsonResponse(false, null);
        }

        $departaments = $this->Departaments->find()
            ->where([
                'id_educations' => $educationId
            ])
            ->all();

        return $this->Core->jsonResponse(true, null, [
            'departaments' => $departaments,
            'education' => $education
        ]);
    }

    public function addDepartament() {
        $title = $this->request->getData('title');
        $educationId = $this->request->getData('edicationId');

        if (empty($title) || !is_numeric($educationId)) {
            return $this->Core->jsonResponse(false, 'Connection Error');
        }

        $departament = $this->Departaments->newEntity();

        $departament->title = $title;
        $departament['id_educations'] = $educationId;

        if ($this->Departaments->save($departament)) {
            return $this->Core->jsonResponse(true, 'Запит доданий!', [
                'departament' => $departament
            ]);
        }

        return $this->Core->jsonResponse(false, 'Помилка сервера!');
    }

    public function updateDepartament() {
        $id = $this->request->getData('id');
        $title = $this->request->getData('title');

        if (!is_numeric($id) || empty($title)) {
            return $this->Core->jsonResponse(false, 'Connection Error');
        }

        $departament = $this->Departaments->get($id);

        $editEepartament = $this->Departaments->patchEntity($departament, [
            'title' => $title
        ]);

        if ($this->Departaments->save($editEepartament)) {
            return $this->Core->jsonResponse(true, 'Факультет оновлено!', [
                'departament' => $departament
            ]);
        }

        return $this->Core->jsonResponse(false, 'Помилка сервера!');
    }

    public function deleteDepartament() {
        $id = $this->request->getData('id');

        if (!is_numeric($id)) {
            return $this->Core->jsonResponse(false, 'Connection Error');
        }

        $departament = $this->Departaments->get($id);

        //  delete all specialty
        $this->Specialty->deleteAll([
            'id_departament' => $departament->id
        ]);

        if ($this->Departaments->delete($departament)) {
            return $this->Core->jsonResponse(true, 'Факультет видалено!');
        }

        return $this->Core->jsonResponse(false, 'Помилка сервера!');
    }
}
