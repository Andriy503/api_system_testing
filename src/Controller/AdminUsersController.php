<?php
namespace App\Controller;

use App\Controller\AppController;
use Firebase\JWT\JWT;
use Cake\Utility\Security;
use Cake\ORM\Query;

/**
 * AdminUsers Controller
 *
 * @property \App\Model\Table\AdminUsersTable $AdminUsers
 *
 * @method \App\Model\Entity\AdminUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AdminUsersController extends AppController
{
    public function initialize () {
        parent::initialize();

        $this->loadModel('AdminUsers');

        $this->Auth->allow(['login']);
    }

    public function login () {
        if ($this->request->is('post')) {
            $login = $this->request->getData('login', false);
            $password = $this->request->getData('password', false);

            $adminUsers = $this->AdminUsers->find()
                ->where([
                    'login' => $login
                ])
                ->first();

            if ($adminUsers->password == $password) {
                return $this->Core->jsonResponse(true, 'Success', [
                    'token' => JWT::encode(
                        [
                            'sub' => $adminUsers->id,
                            'user' => $adminUsers
                        ],
                        Security::getSalt()
                    ),
                    'admin_user' => $adminUsers
                ]);
            }

            return $this->Core->jsonResponse(false, 'Error');
        }

        return $this->Core->jsonResponse(true);
    }
}
