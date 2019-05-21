<?php
use Migrations\AbstractMigration;

class AddTableBundles extends AbstractMigration
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

        if (!$table->exists()) {
            $table
                ->addColumn('a_question', 'string', [
                    'null' => false
                ])
                ->addColumn('a_answer', 'string', [
                    'null' => false
                ])
                ->addColumn('id_answer', 'integer')

                ->addForeignKey('id_answer', 'answers')
                ->save();
        }
    }
}
