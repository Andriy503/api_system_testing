<?php
use Migrations\AbstractMigration;

class AddFieldPrePathToSpecialty extends AbstractMigration
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

        if ($table->exists()) {
            $table
                ->addColumn('pre_path', 'string', [
                    'null' => true,
                    'default' => null,
                    'after' => 'id_departament'
                ])
                ->update();
        }
    }
}
