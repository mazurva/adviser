<?php namespace Adviser\Utilities;

class FileUtility extends AbstractUtility
{

    /**
     * Check if a file/directory exists.
     *
     * @param string $path
     * @return boolean
     */
    public function exists($path)
    {
        return file_exists($path);
    }

    /**
     * Check if any of given files/directories exists.
     *
     * @param string $directory
     * @param array $files
     * @return boolean
     */
    public function anyExists($directory, array $files)
    {
        foreach ($files as $file) {
            if ($this->exists($directory."/".$file)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Read a file.
     *
     * @param string $file
     * @return string|null
     */
    public function read($file)
    {
        if ( ! $this->exists($file)) {
            return null;
        }

        return file_get_contents($file);
    }
}
