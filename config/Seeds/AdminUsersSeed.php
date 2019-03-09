<?php
use Migrations\AbstractSeed;

/**
 * AdminUsers seed.
 */
class AdminUsersSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'id' => 1,
            'login' => 'devExample2019@gmail.com',
            'password' => (new \Cake\Auth\DefaultPasswordHasher())->hash('aUB.{RyjH>G9jv'),
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s')
        ];

        $table = $this->table('admin_users');

        try {
            $table->insert($data)->save();
        } catch (\Exception $e) {

        }
    }
}
