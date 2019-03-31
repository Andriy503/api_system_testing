<?php
use Migrations\AbstractMigration;

class Departments extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('departaments');

        if (!$table->exists()) {
            $table
                ->addColumn('title', 'string', [
                    'limit' => 200
                ])
                ->addColumn('id_educations', 'integer')

                ->addForeignKey('id_educations', 'educational_subdivisions')
                ->addTimestamps('created', 'modified')
                ->create();
        }
    }
}
