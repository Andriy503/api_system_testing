<?php
use Migrations\AbstractMigration;

class AddFieldPathImageToAnswers extends AbstractMigration
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

        if ($table->exists()) {
            $table
                ->addColumn('pre_img', 'text', [
                    'default' => null,
                    'null' => true,
                    'after' => 'id_question'
                ])
                ->update();
        }
    }
}
