<?php
use Migrations\AbstractMigration;

class Courses extends AbstractMigration
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
        $table = $this->table('courses');

        if(!$table->exists()) {
            $table
                ->addColumn('title', 'string', [
                    'limit' => 255
                ])
                ->addTimestamps('created', 'modified')
                ->create();
        }
    }
}
