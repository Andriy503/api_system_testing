<?php
use Migrations\AbstractSeed;

/**
 * AdminRoles seed.
 */
class AdminRolesSeed extends AbstractSeed
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
            [
                'id' => 1,
                'title' => 'Адміністратор',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'title' => 'Вчитель',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ]
        ];

        foreach ($data as $d) {
            try {
                $table = $this->table('admin_roles');

                $table->insert((array)$d)->save();
            } catch (\Exception $e) {
                continue;
            }
        }
    }
}
