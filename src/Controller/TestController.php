<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Test Controller
 *
 *
 * @method \App\Model\Entity\Test[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TestController extends AppController
{
    public function initialize() {
        parent::initialize();

        $this->loadModel('AdminUsers');
    }

    public function show () {
        $adminUsers = $this->AdminUsers->find()->all();

        return $this->Core->jsonResponse(true, 'Its work!!!',[
            'adminUsers' => $adminUsers
        ]);
    }
}
