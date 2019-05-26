<?php
use Migrations\AbstractMigration;

class EntrantAnswers extends AbstractMigration
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
        $table = $this->table('entrant_answers');

        if (!$table->exists()) {
            $table
                ->addColumn('id_entrant', 'integer', [
                    'null' => false
                ])
                ->addColumn('id_question', 'integer', [
                    'null' => false
                ])
                ->addColumn('answers', 'string', [
                    'null' => false,
                    'limit' => 255
                ])

                ->addForeignKey('id_entrant', 'entrants')
                ->addForeignKey('id_question', 'questions')

                ->addTimestamps('created', 'modified')
                ->save();
        }
    }
}
