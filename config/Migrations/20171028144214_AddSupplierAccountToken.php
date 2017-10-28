<?php
use Migrations\AbstractMigration;

class AddSupplierAccountToken extends AbstractMigration
{

    public function up()
    {

        $this->table('suppliers')
            ->addColumn('account_token', 'string', [
                'after' => 'name',
                'default' => null,
                'length' => 255,
                'null' => false,
            ])
            ->update();
    }

    public function down()
    {

        $this->table('suppliers')
            ->removeColumn('account_token')
            ->update();
    }
}

