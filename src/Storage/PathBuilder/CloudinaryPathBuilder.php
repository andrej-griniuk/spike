<?php
namespace App\Storage\PathBuilder;

use App\Storage\Adapter\Cloudinary;
use Burzum\FileStorage\Storage\PathBuilder\BasePathBuilder;
use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Utility\Hash;

class CloudinaryPathBuilder extends BasePathBuilder
{

    /**
     * Builds the URL under which the file is accessible.
     *
     * This is for example important for S3 and Dropbox but also the Local adapter
     * if you symlink a folder to your webroot and allow direct access to a file.
     *
     * @param \Cake\Datasource\EntityInterface $entity
     * @param array $options
     * @return string
     */
    public function url(EntityInterface $entity, array $options = [])
    {
        if ($entity->get('adapter') !== 'Cloudinary') {
            return parent::url($entity, $options);
        }

        $publicId = Cloudinary::getPublicIdFromPath($entity->get('path'));
        $params = [];

        if ($fileSuffix = Hash::get($options, 'fileSuffix')) {
            $fileSuffix = explode('.', $fileSuffix);
            $fileSuffix = $fileSuffix[1];
            $repository = $entity->getSource();
            $version = array_search($fileSuffix, Configure::read("FileStorage.imageHashes.{$repository}"));
            if ($size = Configure::read("FileStorage.imageSizes.{$repository}.{$version}.thumbnail")) {
                $params['crop'] = 'fill';
                $params['width'] = $size['width'];
                $params['height'] = $size['height'];
            }
        }

        return cloudinary_url_internal($publicId, $params) . '.' . $entity->get('extension');
    }
}
