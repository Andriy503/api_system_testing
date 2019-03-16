<?php
namespace App\Controller;

use App\Controller\AppController;
use Firebase\JWT\JWT;
use Cake\Utility\Security;
use Cake\ORM\Query;
use Cake\Auth\DefaultPasswordHasher;

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

        $this->Auth->allow(['login', 'registration']);
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

            if (empty($adminUsers)) {
                return $this->Core->jsonResponse(false, 'Введіть коректно логін або пароль!');
            }

            if (empty($password) || !(new DefaultPasswordHasher())->check($password, $adminUsers->password)) {
                return $this->Core->jsonResponse(false, 'Введіть коректно логін або пароль!');
            }

            return $this->Core->jsonResponse(true, 'Успішний вхід', [
                'token' => JWT::encode(
                    [
                        'sub' => $adminUsers->id,
                        'exp' =>  time() + 3600,
                        'user' => $adminUsers
                    ],
                    Security::getSalt()
                ),
                'admin_user' => $adminUsers
            ]);
        }
    }

    public function registration () {
        $requestData = $this->request->getData();

        if ($this->AdminUsers->exists(['login' => $requestData['login']])) {
            return $this->Core->jsonResponse(false, 'Такий логін вже використовується!');
        }

        if ($requestData['password'] !== $requestData['retryPassword']) {
            return $this->Core->jsonResponse(false, 'Паролі не співпадають!');
        }

        $newAdminUser = $this->AdminUsers->newEntity($requestData);

        if ($this->AdminUsers->save($newAdminUser)) {
            $newUser = $this->AdminUsers->get($newAdminUser->id);

            return $this->Core->jsonResponse(true, 'Ви успішно зареєструвались!', [
                'token' => JWT::encode(
                    [
                        'sub' => $newUser->id,
                        'exp' =>  time() + 3600,
                        'user' => $newUser
                    ],
                    Security::getSalt()
                ),
                'admin_user' => $newUser
            ]);
        }

        return $this->Core->jsonResponse(false, $this->_parseEntityErrors($newAdminUser->getErrors()));
    }
}
