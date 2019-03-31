<?php
use Migrations\AbstractSeed;

/**
 * Departaments seed.
 */
class DepartamentsSeed extends AbstractSeed
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
                'title' => 'Кафедра фізики',
                'id_educations' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'title' => 'Кафедра математики',
                'id_educations' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 3,
                'title' => 'Кафедра інформатики та інформаційних систем',
                'id_educations' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 4,
                'title' => 'Кафедра економіки та менеджменту',
                'id_educations' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 5,
                'title' => 'Кафедра технологічної та професійної освіти',
                'id_educations' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 6,
                'title' => 'Кафедра практики англійської мови',
                'id_educations' => 2,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 7,
                'title' => 'Кафедра практики німецької мови',
                'id_educations' => 2,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 8,
                'title' => 'Кафедра германських мов і перекладознавства',
                'id_educations' => 2,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 9,
                'title' => 'Кафедра романської філології та компаративістики',
                'id_educations' => 2,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 10,
                'title' => 'Кафедра порівняльної педагогіки і методики викладання іноземних мов',
                'id_educations' => 2,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 11,
                'title' => 'Кафедра мовної та міжкультурної комунікації',
                'id_educations' => 2,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 12,
                'title' => 'Кафедра методики музичного виховання і диригування',
                'id_educations' => 3,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 13,
                'title' => 'Кафедра музикознавства та фортепіано',
                'id_educations' => 3,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 14,
                'title' => 'Кафедра народних музичних інструментів та вокалу',
                'id_educations' => 3,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 15,
                'title' => 'Кафедра української мови',
                'id_educations' => 5,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 16,
                'title' => 'Кафедра української літератури та теорії літератури',
                'id_educations' => 5,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 17,
                'title' => 'Кафедра світової літератури та славістики',
                'id_educations' => 5,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 18,
                'title' => 'Кафедра історії України',
                'id_educations' => 6,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 19,
                'title' => 'Кафедра всесвітньої історії та спеціальних історичних дисциплін',
                'id_educations' => 6,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 20,
                'title' => 'Кафедра філософії  імені професора Валерія Григоровича Скотного',
                'id_educations' => 6,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 21,
                'title' => 'Кафедра правознавства, соціології та політології',
                'id_educations' => 6,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 22,
                'title' => 'Кафедра педагогіки та методики початкової освіти',
                'id_educations' => 7,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 23,
                'title' => 'Кафедра математики, інформатики та методики їх викладання у початковій школі',
                'id_educations' => 7,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 24,
                'title' => 'Кафедра філологічних дисциплін та методики їх викладання у початковій школі',
                'id_educations' => 7,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 25,
                'title' => 'Кафедра культурології та мистецької освіти',
                'id_educations' => 7,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 26,
                'title' => 'Кафедра екології та географії',
                'id_educations' => 8,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 27,
                'title' => 'Кафедра анатомії, фізіології та валеології',
                'id_educations' => 8,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 28,
                'title' => 'Кафедра біології та хімії',
                'id_educations' => 8,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 29,
                'title' => 'Кафедра соціальної педагогіки та корекційної освіти',
                'id_educations' => 9,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 30,
                'title' => 'Кафедра загальної педагогіки та дошкільної освіти',
                'id_educations' => 9,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 31,
                'title' => 'Кафедра практичної психології',
                'id_educations' => 9,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 32,
                'title' => 'Кафедра психології',
                'id_educations' => 9,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ]
        ];

        foreach ($data as $d) {
            try {
                $table = $this->table('departaments');

                $table->insert((array)$d)->save();
            } catch (\Exception $e) {
                continue;
            }
        }
    }
}
