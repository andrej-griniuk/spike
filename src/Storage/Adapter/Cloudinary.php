<?php

namespace App\Storage\Adapter;

use Cake\Utility\Hash;
use Exception;
use Gaufrette\Adapter;

/**
 * Cloudinary adapter
 *
 * @author  Andrej Griniuk <andrej.griniuk@gmail.com>
 */
class Cloudinary implements Adapter
{

    /**
     * Reads the content of the file
     *
     * @param string $key
     *
     * @return string|boolean if cannot read content
     */
    public function read($key)
    {
        // TODO: Implement read() method.
    }

    /**
     * Writes the given content into the file
     *
     * @param string $key
     * @param string $content
     *
     * @return integer|boolean The number of bytes that were written into the file
     */
    public function write($key, $content)
    {
        $tmp = tempnam(TMP, 'cloudinary');
        file_put_contents($tmp, $content);

        try {
            $publicId = static::getPublicIdFromPath($key);
            $result = \Cloudinary\Uploader::upload($tmp, ['public_id' => $publicId]);
            unlink($tmp);

            return Hash::get($result, 'bytes', false);
        } catch (\Exception $e) {
            unlink($tmp);

            return false;
        }
    }

    /**
     * Indicates whether the file exists
     *
     * @param string $key
     *
     * @return boolean
     */
    public function exists($key)
    {
        // TODO: Implement exists() method.
        return true;
    }

    /**
     * Returns an array of all keys (files and directories)
     *
     * @return array
     */
    public function keys()
    {
        // TODO: Implement keys() method.
    }

    /**
     * Returns the last modified time
     *
     * @param string $key
     *
     * @return integer|boolean An UNIX like timestamp or false
     */
    public function mtime($key)
    {
        // TODO: Implement mtime() method.
    }

    /**
     * Deletes the file
     *
     * @param string $key
     *
     * @return boolean
     */
    public function delete($key)
    {
        try {
            \Cloudinary\Uploader::destroy(static::getPublicIdFromPath($key));
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Renames a file
     *
     * @param string $sourceKey
     * @param string $targetKey
     *
     * @return boolean
     */
    public function rename($sourceKey, $targetKey)
    {
        // TODO: Implement rename() method.
    }

    /**
     * Check if key is directory
     *
     * @param string $key
     *
     * @return boolean
     */
    public function isDirectory($key)
    {
        // TODO: Implement isDirectory() method.
    }

    public static function getPublicIdFromPath($path)
    {
        $path = ltrim($path, DIRECTORY_SEPARATOR);
        $path = explode('.', $path);
        array_pop($path);

        return implode('.', $path);
    }
}
