<?php
use Migrations\AbstractMigration;

class AddFieldIdEducationAndIdDepartamentTableAdminUsers extends AbstractMigration
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
        $table = $this->table('admin_users');

        if ($table->exists()) {
            $table
                ->addColumn('id_education', 'integer', [
                    'null' => true,
                    'after' => 'role_id'
                ])
                ->addColumn('id_departament', 'integer', [
                    'null' => true,
                    'after' => 'id_education'
                ])
                ->addForeignKey('id_education', 'educational_subdivisions')
                ->addForeignKey('id_departament', 'departaments')
                ->update();
        }
    }
}
