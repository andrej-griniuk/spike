<?php
use Migrations\AbstractMigration;

class AddSupplierIdentifierAndSlug extends AbstractMigration
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
        $this->table('suppliers')
            ->addColumn('slug', 'string', [
                'after' => 'name',
                'default' => null,
                'length' => 255,
                'null' => false,
            ])
            ->addColumn('identifier', 'string', [
                'after' => 'slug',
                'default' => null,
                'length' => 255,
                'null' => false,
            ])
            ->update();

        $Suppliers = \Cake\ORM\TableRegistry::get('Suppliers');
        /** @var \App\Model\Entity\Supplier[] $suppliers */
        $suppliers = $Suppliers->find()->all();
        foreach ($suppliers as $supplier) {
            if ($supplier->name == 'AGL') {
                $supplier->slug = 'Alg';
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
