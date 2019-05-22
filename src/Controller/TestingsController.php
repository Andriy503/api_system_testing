<?php
namespace App\Controller;

use App\Controller\AppController;

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

        $this->Auth->allow(['verificationEntrant']);
    }

    public function verificationEntrant() {
        if ($this->request->is('POST')) {
            $params = (object)$this->request->getData();

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

            return $this->Core->jsonResponse(true, 'Абітурієнт верифікований!', [
                'entrant' => $entrant
            ]);
        }
    }
}
