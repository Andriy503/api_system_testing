<?php
use Migrations\AbstractMigration;

class EntrantToTicket extends AbstractMigration
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
        $table = $this->table('entrant_to_ticket');

        if (!$table->exists()) {
            $table
                ->addColumn('id_entrant', 'integer')
                ->addColumn('id_ticket', 'integer')
                ->addColumn('is_done', 'boolean', [
                    'default' => 0
                ])
                ->addColumn('rating', 'integer')
                ->addForeignKey('id_entrant', 'entrants')
                ->addForeignKey('id_ticket', 'tickets')

                ->addTimestamps('created', 'modified')
                ->save();
        }
    }
}
