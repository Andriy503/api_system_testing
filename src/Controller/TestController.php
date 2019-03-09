<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Query;

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
        // $this->loadComponent('RequestHandler');
        $this->loadModel('AdminUsers');
    }

    public function show () {
        $adminUsers = $this->AdminUsers->find()->all();

        $new = $this->AdminUsers->newEntity([
            'login' => 'sokol',
            'password' => 'sokol'
        ]);

        $this->AdminUsers->save($new);

        return $this->Core->jsonResponse(true, 'Its work!!!',[
            'adminUsers' => $adminUsers
        ]);
    }

    public function test () {
        return $this->Core->jsonResponse(true, 'Post request success!');
    }
}
