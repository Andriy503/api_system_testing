<?php
use Migrations\AbstractMigration;

class AdminUsers extends AbstractMigration
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

        if(!$table->exists()) {
            $table
                ->addColumn('login', 'string', [
                    'limit' => 50
                ])
                ->addColumn('password', 'string', [
                    'limit' => 255
                ])
                ->addTimestamps('created', 'modified')
                ->create();
        }
    }
}
