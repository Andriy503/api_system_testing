<?php
use Migrations\AbstractMigration;

class AddFieldIsFullAnswersToQuestions extends AbstractMigration
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

        if ($table->exists()) {
            $table
                ->addColumn('is_full_answers', 'boolean', [
                    'default' => false,
                    'null' => true,
                    'after' => 'id_type'
                ])
                ->update();
        }
    }
}
