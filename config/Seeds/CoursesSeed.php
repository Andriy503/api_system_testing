<?php
use Migrations\AbstractSeed;

/**
 * Courses seed.
 */
class CoursesSeed extends AbstractSeed
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
                'title' => 'Вступ абітурієнта',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ]
        ];

        foreach ($data as $d) {
            try {
                $table = $this->table('courses');

                $table->insert((array)$d)->save();
            } catch (\Exception $e) {
                continue;
            }
        }
    }
}
