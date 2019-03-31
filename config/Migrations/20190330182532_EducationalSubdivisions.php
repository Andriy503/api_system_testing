<?php
use Migrations\AbstractMigration;

class EducationalSubdivisions extends AbstractMigration
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
        $table = $this->table('educational_subdivisions');

        if (!$table->exists()) {
            $table
                ->addColumn('title', 'string', [
                    'limit' => 200
                ])
                ->addTimestamps('created', 'modified')
                ->create();
        }
    }
}
