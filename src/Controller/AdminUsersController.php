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
        $this->loadModel('EducationalSubdivisions');

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

            if (!$adminUsers->is_ver) {
                return $this->Core->jsonResponse(false, 'Користувач не підтверджений адміністратором!');
            }

            if ($adminUsers->is_delete) {
                return $this->Core->jsonResponse(false, 'Користувач видалений!');
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
                'user' => $adminUsers
            ]);
        }
    }

    public function registration () {
        $requestData = $this->request->getData();

        $requestData['id_departament'] = (!$requestData['idDepartament']) ? null : $requestData['idDepartament'];

        $isEducation = $this->EducationalSubdivisions->find()
            ->where([
                'id' => $requestData['idEducation']
            ]);

        if ($isEducation->isEmpty()) {
            return $this->Core->jsonResponse(false, 'Виберіть навчаьний підрозділ!');
        }

        $requestData['id_education'] = $requestData['idEducation'];

        if ($this->AdminUsers->exists(['login' => $requestData['login']])) {
            return $this->Core->jsonResponse(false, 'Такий логін вже використовується!');
        }

        if ($requestData['password'] !== $requestData['retryPassword']) {
            return $this->Core->jsonResponse(false, 'Паролі не співпадають!');
        }

        $requestData['role_id'] = 2;

        $newAdminUser = $this->AdminUsers->newEntity($requestData);

        if ($this->AdminUsers->save($newAdminUser)) {
            // $newUser = $this->AdminUsers->get($newAdminUser->id);

            // return $this->Core->jsonResponse(true, 'Ви успішно зареєструвались!', [
            //     'token' => JWT::encode(
            //         [
            //             'sub' => $newUser->id,
            //             'exp' =>  time() + 3600,
            //             'user' => $newUser
            //         ],
            //         Security::getSalt()
            //     ),
            //     'user' => $newUser
            // ]);

            return $this->Core->jsonResponse(true, 'Ви успішно зареєструвались, чекайте підтвердження адміністратора!');
        }

        return $this->Core->jsonResponse(false, $this->_parseEntityErrors($newAdminUser->getErrors()));
    }

    public function getMe() {
        // var_dump($this->Auth->user());
        return $this->Core->jsonResponse(true, null, [
            'user' => $this->Auth->user()
        ]);
    }

    public function logout() {
        $this->Auth->logout();

        return $this->Core->jsonResponse(true, null);
    }

    public function getAdminUsers() {
        $adminUsers = $this->AdminUsers->find()
            ->contain([
                'AdminRoles',
                'EducationalSubdivisions',
                'Departaments'
            ])
            ->where([
                'AdminUsers.is_delete' => false
            ])
            ->all();

        return $this->Core->jsonResponse(true, null, [
            'adminUsers' => $adminUsers
        ]);
    }

    public function verifiedAdminUser() {
        $user = $this->AdminUsers->get($this->request->getQuery('userId'));

        $editUser = $this->AdminUsers->patchEntity($user, [
            'is_ver' => !$user->is_ver
        ]);

        if ($this->AdminUsers->save($editUser)) {
            return $this->Core->jsonResponse(true, 'Змінни збережені!');
        }

        return $this->Core->jsonResponse(false, 'Помилка сервера зверніться до адміністратора!');
    }

    public function deleteUser() {
        $user = $this->AdminUsers->get($this->request->getQuery('userId'));

        $editUser = $this->AdminUsers->patchEntity($user, [
            'is_delete' => !$user->is_delete
        ]);

        if ($this->AdminUsers->save($editUser)) {
            return $this->Core->jsonResponse(true, 'Користувач видалений!');
        }

        return $this->Core->jsonResponse(false, 'Помилка сервера зверніться до адміністратора!');
    }
}
