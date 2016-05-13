<?php

namespace videocast\builder;

/**
 * Class Utils
 * @package videocast\builder
 */
class Utils
{
    /**
     * @param $filename
     * @return string
     */
    public static function getContent($filename)
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return '';
        }

        $file = trim(file_get_contents($filename));
        preg_match('#\<\?php(.*)#is', $file, $data);

        return $data
            ? rtrim(rtrim(trim($data[1]), '?>'))
            : $file;
    }

    /**
     * @param $directory
     */
    public static function removeDirectory($directory)
    {
        if (!is_dir($directory)) {
            return;
        }

        $objects = scandir($directory);
        foreach ($objects as $object) {
            if ($object == "." || $object == "..") {
                continue;
            }
            if (filetype($directory . "/" . $object) == "dir") {
                static::removeDirectory($directory . "/" . $object);
            } else {
                unlink($directory . "/" . $object);
            }
        }

        reset($objects);
        rmdir($directory);
    }
}
