<?php
use Migrations\AbstractMigration;

class Tickets extends AbstractMigration
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
        $table = $this->table('tickets');

        if(!$table->exists()) {
            $table
                ->addColumn('title', 'string', [
                    'limit' => 255
                ])
                ->addColumn('time_of_passing', 'integer', [
                    'default' => 3600
                ])
                ->addColumn('count_question', 'integer', [
                    'default' => 20
                ])
                ->addColumn('id_specialty', 'integer')
                ->addColumn('id_course', 'integer', [
                    'default' => 1
                ])
                ->addForeignKey('id_specialty', 'specialty')
                ->addForeignKey('id_course', 'courses')
                ->addTimestamps('created', 'modified')
                ->create();
        }
    }
}
