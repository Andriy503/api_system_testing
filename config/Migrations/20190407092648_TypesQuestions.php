<?php
use Migrations\AbstractMigration;

class TypesQuestions extends AbstractMigration
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
        $table = $this->table('types_questions');

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
