<?php
namespace App\Model\Table;

use Burzum\FileStorage\Model\Table\ImageStorageTable as Table;
use Cake\Core\Configure;

class ImageStorageTable extends Table
{
    public function upload($id, $entity)
    {
        $entity = $this->patchEntity($entity, [
            'adapter'     => Configure::read('FileStorage.adapter'),
            'model'       => $this->_alias,
            'foreign_key' => $id
        ]);

        return $this->save($entity);
    }
}
