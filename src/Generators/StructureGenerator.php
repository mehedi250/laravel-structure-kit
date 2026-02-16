<?php

namespace StructureKit\Generators;

use Illuminate\Support\Facades\File;

class StructureGenerator
{
    /**
     * Ensure a directory exists and set safe permissions
     */
    public function ensureDirectory(string $path): void
    {
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
            $this->setPermissionsRecursive($path);
        }
    }

    /**
     * Create a file with content and safe permissions
     */
    public function createFile(string $path, string $content): bool
    {
        if (File::exists($path)) {
            return false; // prevent overwriting
        }

        $this->ensureDirectory(dirname($path));
        File::put($path, $content);
        $this->setPermissionsRecursive($path);

        return true;
    }

    /**
     * Generate a file from a stub
     * 
     * @param string $stubName   Name of the stub file in src/stubs/
     * @param string $targetPath Full path to generate the file
     * @param array $replacements Key-value replacements for placeholders
     */
    public function generateFromStub(string $stubName, string $targetPath, array $replacements = []): string
    {
        $stubPath = __DIR__ . '/../stubs/' . $stubName;

        if (!File::exists($stubPath)) {
            throw new \Exception("Stub file not found: {$stubName}");
        }

        $content = File::get($stubPath);

        foreach ($replacements as $key => $value) {
            $content = str_replace('{{ ' . $key . ' }}', $value, $content);
        }

        // Detect unreplaced placeholders
        // if (preg_match('/{{\s*\w+\s*}}/', $content)) {
        //     dd($replacements);

        //     throw new \Exception("Unreplaced placeholders found in {$stubName}");
        // }

        $this->createFile($targetPath, $content);

        return $targetPath;
    }

    /**
     * Recursively set safe permissions and ownership
     */
    private function setPermissionsRecursive(string $path): void
    {
        $hostUser = getenv('HOST_USER') ?: 'www-data';
        $hostGroup = getenv('HOST_GROUP') ?: 'www-data';

        if (is_dir($path)) {
            chmod($path, 0775); // folder: rwxrwxr-x
        } else {
            chmod($path, 0664); // file: rw-rw-r--
        }

        @chown($path, $hostUser);
        @chgrp($path, $hostGroup);

        if (is_dir($path)) {
            $items = scandir($path);
            foreach ($items as $item) {
                if ($item === '.' || $item === '..')
                    continue;
                $this->setPermissionsRecursive($path . DIRECTORY_SEPARATOR . $item);
            }
        }
    }
}
