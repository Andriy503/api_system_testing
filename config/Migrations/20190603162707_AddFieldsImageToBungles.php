<?php
use Migrations\AbstractMigration;

class AddFieldsImageToBungles extends AbstractMigration
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
        $table = $this->table('bundles');

        if ($table->exists()) {
            $table
                ->addColumn('q_pre_img', 'text', [
                    'default' => null,
                    'null' => true,
                    'after' => 'a_question'
                ])
                ->addColumn('a_pre_img', 'text', [
                    'default' => null,
                    'null' => true,
                    'after' => 'a_answer'
                ])

                ->update();
        }
    }
}
