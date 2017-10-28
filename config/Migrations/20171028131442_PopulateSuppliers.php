<?php
use Migrations\AbstractMigration;

class PopulateSuppliers extends AbstractMigration
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
        $Suppliers = \Cake\ORM\TableRegistry::get('Suppliers');
        $entities = $Suppliers->newEntities([
            ['name' => 'AGL'],
            ['name' => 'Sydney Water'],
            ['name' => 'RED energy'],
            ['name' => 'The Knight Alliance'],
        ]);
        $Suppliers->saveMany($entities);
    }
}
