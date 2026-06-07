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
    public function createFile(string $path, string $content, bool $force = false): bool
    {
        if (File::exists($path) && !$force) {
            return false;
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
    public function generateFromStub(string $stubName, string $targetPath, array $replacements = [], bool $force = false): bool
    {
        $stubPath = __DIR__ . '/../stubs/' . $stubName;

        if (!File::exists($stubPath)) {
            throw new \Exception("Stub file not found: {$stubName}");
        }

        $content = File::get($stubPath);

        foreach ($replacements as $key => $value) {
            $content = preg_replace('/\{\{\s*' . preg_quote($key, '/') . '\s*\}\}/', $value, $content);
        }

        return $this->createFile($targetPath, $content, $force);
    }

    /**
     * Recursively set safe permissions and ownership
     */
    private function setPermissionsRecursive(string $path): void
    {
        if (PHP_OS_FAMILY !== 'Windows') {
            chmod($path, is_dir($path) ? 0775 : 0664);
        }

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
