<?php
use Migrations\AbstractSeed;

/**
 * Specialty seed.
 */
class SpecialtySeed extends AbstractSeed
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
                'title' => 'Інформатика',
                'is_delete' => 0,
                'short_title' => null,
                'full_name' => '014 Середня освіта (Інформатика)',
                'id_departament' => 3,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'title' => 'Інформатика',
                'is_delete' => 1,
                'short_title' => null,
                'full_name' => '014 Середня освіта (Інформатика)
                (на основі ОКР «Молодший спеціаліст»)',
                'id_departament' => 3,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 3,
                'title' => 'Комп’ютерні науки',
                'is_delete' => 0,
                'short_title' => 'КН',
                'full_name' => '122 Комп’ютерні науки',
                'id_departament' => 3,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 1,
                'title' => 'Комп’ютерні науки',
                'is_delete' => 1,
                'short_title' => 'КН',
                'full_name' => '122 Комп’ютерні науки (на основі ОКР «Молодший спеціаліст»)',
                'id_departament' => 3,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 5,
                'title' => 'Фізика',
                'is_delete' => 0,
                'short_title' => null,
                'full_name' => null,
                'id_departament' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
        ];

        foreach ($data as $d) {
            try {
                $table = $this->table('specialty');

                $table->insert((array)$d)->save();
            } catch (\Exception $e) {
                continue;
            }
        }
    }
}
