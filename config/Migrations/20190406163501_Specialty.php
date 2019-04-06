<?php
use Migrations\AbstractMigration;

class Specialty extends AbstractMigration
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
        $table = $this->table('specialty');

        if(!$table->exists()) {
            $table
                ->addColumn('title', 'string', [
                    'limit' => 255
                ])
                ->addColumn('is_delete', 'boolean', [
                    'default' => 0,
                ])
                ->addColumn('short_title', 'string', [
                    'null' => true,
                    'limit' => 255
                ])
                ->addColumn('full_name', 'text', [
                    'null' => true
                ])
                ->addColumn('id_departament', 'integer')

                ->addForeignKey('id_departament', 'departaments')
                ->addTimestamps('created', 'modified')
                ->create();
        }
    }
}
