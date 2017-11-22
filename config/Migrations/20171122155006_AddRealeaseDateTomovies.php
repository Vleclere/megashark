<?php
use Migrations\AbstractMigration;

class AddRealeaseDateTomovies extends AbstractMigration
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
        $table = $this->table('movies');
        $table->addColumn('release_date', 'date', [
            'default' => null,
            'null' => false,
        ]);
        $table->update();
    }
}
