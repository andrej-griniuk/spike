<?php
use Burzum\FileStorage\Storage\Listener\BaseListener;
use Burzum\FileStorage\Storage\StorageManager;
use Burzum\FileStorage\Storage\StorageUtils;
use Cake\Core\Configure;
use Cake\Event\EventManager;

// Instantiate a storage event listener
$listener = new BaseListener([
    'imageProcessing' => true, // Required if you want image processing!
    'pathBuilder' => 'Cloudinary',
    'pathBuilderOptions' => [
        'pathPrefix' => '/img',
        // Preserves the original filename in the storage backend.
        // Otherwise it would use a UUID as filename by default.
        //'preserveFilename' => true
    ]
]);

// Attach the BaseListener to the global EventManager
EventManager::instance()->on($listener);

//Configure::write('FileStorage.adapter', (env('ENV') == 'dev') ? 'Local' : 'Cloudinary');
Configure::write('FileStorage.adapter', 'Cloudinary');

// Configure image versions on a per model base
Configure::write('FileStorage.imageSizes', [
    'Scans' => [
        'lg'  => [
            'thumbnail' => [
                'mode'   => 'outbound',
                'width'  => 768,
                'height' => 1024
            ]
        ],
        'md' => [
            'thumbnail' => [
                'mode'   => 'outbound',
                'width'  => 600,
                'height' => 800
            ]
        ],
        'sm'  => [
            'thumbnail' => [
                'mode'   => 'outbound',
                'width'  => 340,
                'height' => 480
            ]
        ]
    ],
]);

// This is very important! The hashes are needed to calculate the image versions!
StorageUtils::generateHashes();

StorageManager::setConfig('Local', array(
    'adapterOptions' => [WWW_ROOT, true],
    'adapterClass'   => '\Gaufrette\Adapter\Local',
    'class'          => '\Gaufrette\Filesystem'
));

if (Configure::read('FileStorage.adapter') === 'Cloudinary') {
    Cloudinary::config(array(
        'cloud_name' => env('CLOUDINARY_CLOUD_NAME', 'hpsbokihh'),
        'api_key' => env('CLOUDINARY_API_KEY', '722253912288586'),
        'api_secret' => env('CLOUDINARY_API_SECRET', 'Vf-lYcL0RUqFu84fFE79RGXbtto'),
    ));

    StorageManager::setConfig('Cloudinary', [
        'adapterOptions' => [],
        'adapterClass'   => '\App\Storage\Adapter\Cloudinary',
        'class'          => '\Gaufrette\Filesystem',
    ]);
}
