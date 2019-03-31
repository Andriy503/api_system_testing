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

        $this->Auth->allow(['getEducations']);
    }

    public function getEducations() {
        $educations = $this->EducationalSubdivisions->find()->all();
        $departaments = $this->Departaments->find()->all();

        return $this->Core->jsonResponse(true, null, [
            'educations' => $educations,
            'departaments' => $departaments
        ]);
    }
}
