<?php

namespace EscolaLms\HeadlessH5P\Helpers;

use Illuminate\Support\Facades\Storage;

class Helpers
{
    /**
     * fix case key arrays for mysql/postges/other case sensitive results
     */
    public static function fixCaseKeysArray($keys, $array)
    {
        if (is_object($array)) {
            $row = $array;
            foreach ($keys as $key) {
                $lckey = strtolower($key);
                if (is_array($row) && !isset($row[$key]) && isset($row[$lckey])) {
                    $row[$key] = $row[$lckey];
                }
                if (is_object($row) && !isset($row->$key) && isset($row->$lckey)) {
                    $row->$key = $row->$lckey;
                }
            }
        } else {
            foreach ($array as $row_key => $row) {
                foreach ($keys as $key) {
                    $lckey = strtolower($key);
                    if (is_array($row) && !isset($row[$key]) && isset($row[$lckey])) {
                        $row[$key] = $row[$lckey];
                    }
                    if (is_object($row) && !isset($row->$key) && isset($row->$lckey)) {
                        $row->$key = $row->$lckey;
                    }
                }
            }
        }
    }

    /**
     * Recursive function for removing directories.
     *
     * @param string $dir
     *  Path to the directory we'll be deleting
     * @return boolean
     *  Indicates if the directory existed.
     */
    public static function deleteFileTree(string $dir): bool
    {
        $disk = Storage::disk('upload');
        if (!$disk->directoryExists($dir)) {
            return false;
        }
        if (is_link($dir)) {
            // Do not traverse and delete linked content, simply unlink.
            unlink($dir);
            return true;
        }

        foreach ($disk->directories($dir) as $directory) {
            self::deleteFileTree($directory);
        }
        foreach ($disk->files($dir) as $file) {
            $disk->delete($file);
        }

        return $disk->deleteDirectory($dir);
    }

    public static function deleteFileTreeLocal($dir)
    {
        if (!is_dir($dir)) {
            return false;
        }

        if (is_link($dir)) {
            // Do not traverse and delete linked content, simply unlink.
            unlink($dir);
            return;
        }

        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            $filepath = "$dir/$file";
            // Note that links may resolve as directories
            if (!is_dir($filepath) || is_link($filepath)) {
                // Unlink files and links
                unlink($filepath);
            } else {
                // Traverse subdir and delete files
                self::deleteFileTreeLocal($filepath);
            }
        }

        return rmdir($dir);
    }
}
