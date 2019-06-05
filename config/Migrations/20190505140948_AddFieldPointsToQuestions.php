<?php
use Migrations\AbstractMigration;

class AddFieldPointsToQuestions extends AbstractMigration
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
                ->addColumn('points', 'integer', [
                    'null' => false,
                    'after' => 'id_type'
                ])
                ->update();
        }
    }
}
