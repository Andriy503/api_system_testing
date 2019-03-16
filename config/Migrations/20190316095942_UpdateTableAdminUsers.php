<?php
use Migrations\AbstractMigration;

class UpdateTableAdminUsers extends AbstractMigration
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
                ->addColumn('name', 'string', [
                    'limit' => 50,
                    'after' => 'password'
                ])
                ->addColumn('last_name', 'string', [
                    'limit' => 50,
                    'after' => 'name'
                ])
                ->addColumn('is_delete', 'boolean', [
                    'default' => 0,
                    'after' => 'id'
                ])
                ->addColumn('avatar_path', 'string', [
                    'limit' => 255,
                    'after' => 'last_name',
                    'null' => true
                ])
                ->addColumn('about', 'text', [
                    'after' => 'avatar_path',
                    'null' => true
                ])
                ->update();
        }
    }
}
