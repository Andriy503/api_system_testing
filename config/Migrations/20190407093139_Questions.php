<?php
use Migrations\AbstractMigration;

class Questions extends AbstractMigration
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
        $table = $this->table('questions');

        if(!$table->exists()) {
            $table
                ->addColumn('title', 'text', [
                    'null' => false
                ])
                ->addColumn('pre_img', 'text', [
                    'default' => null,
                    'null' => true
                ])
                ->addColumn('id_ticket', 'integer')
                ->addColumn('id_type', 'integer')
                ->addForeignKey('id_ticket', 'tickets')
                ->addForeignKey('id_type', 'types_questions')
                ->addTimestamps('created', 'modified')
                ->create();
        }
    }
}
