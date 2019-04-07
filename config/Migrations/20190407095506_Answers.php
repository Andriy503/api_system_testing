<?php
use Migrations\AbstractMigration;

class Answers extends AbstractMigration
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
        $table = $this->table('answers');

        if(!$table->exists()) {
            $table
                ->addColumn('title', 'text', [
                    'null' => false
                ])
                ->addColumn('current_answer', 'boolean', [
                    'default' => false
                ])
                ->addColumn('id_question', 'integer')

                ->addForeignKey('id_question', 'questions')
                ->addTimestamps('created', 'modified')
                ->create();
        }
    }
}
