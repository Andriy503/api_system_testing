<?php
use Migrations\AbstractMigration;

class AddFieldSearchHashToQestions extends AbstractMigration
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
                ->addColumn('search_hash', 'string', [
                    'null' => false,
                    'after' => 'is_full_answers'
                ])
                ->update();
        }
    }
}
