<?php
use Migrations\AbstractMigration;

class Entrants extends AbstractMigration
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
        $table = $this->table('entrants');

        if (!$table->exists()) {
            $table
                ->addColumn('first_name', 'string', [
                    'limit' => 255,
                    'null' => false
                ])
                ->addColumn('last_name', 'string', [
                    'limit' => 255,
                    'null' => false
                ])
                ->addColumn('middle_name', 'string', [
                    'limit' => 255,
                    'null' => false
                ])
                ->addColumn('age', 'date')
                ->addColumn('city', 'string', [
                    'null' => false,
                    'limit' => 255
                ])
                ->addColumn('is_passed', 'boolean', [
                    'null' => false,
                    'default' => false
                ])
                ->addColumn('id_specialty', 'integer', [
                    'null' => false
                ])

                ->addForeignKey('id_specialty', 'specialty')
                ->addTimestamps('created', 'modified')
                ->save();
        }
    }
}
