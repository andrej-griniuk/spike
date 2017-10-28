<?php
use Migrations\AbstractMigration;

class SetSupplierIdentifiers extends AbstractMigration
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
        /** @var \App\Model\Entity\Supplier[] $suppliers */
        $suppliers = $Suppliers->find()->all();
        foreach ($suppliers as $supplier) {
            if ($supplier->name == 'AGL') {
                $supplier->slug = 'Agl';
                $supplier->identifier = 'AGL electricity';
            } elseif ($supplier->name == 'Sydney Water') {
                $supplier->slug = 'SydneyWater';
                $supplier->identifier = 'Website: sydneywater.com.au';
            } elseif ($supplier->name == 'RED energy') {
                $supplier->slug = 'RedEnergy';
                $supplier->identifier = 'redenergy.com.au';
            } elseif ($supplier->name == 'The Knight Alliance') {
                $supplier->slug = 'TheKnightAlliance';
                $supplier->identifier = 'theknight@theknight.com.au';
            }

            $Suppliers->saveOrFail($supplier);
        }
    }
}
