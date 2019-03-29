<?php
use Migrations\AbstractMigration;

class AddRoleIdTableAdminUsers extends AbstractMigration
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
                ->addColumn('role_id', 'integer', [
                    'after' => 'about'
                ])
                ->addForeignKey('role_id', 'admin_roles')
                ->update();
        }
    }
}
