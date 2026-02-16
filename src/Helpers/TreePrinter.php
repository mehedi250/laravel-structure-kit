<?php

namespace StructureKit\Helpers;

use Symfony\Component\Console\Output\ConsoleOutput;

class TreePrinter
{
    protected $output;

    public function __construct(ConsoleOutput $output)
    {
        $this->output = $output;
    }

    /**
     * Print a nested tree from a list of generated files
     *
     * @param array $files Absolute file paths
     * @param array $highlightMap Folder/file name => color
     */
    public function printFiles(array $files, array $highlightMap = []): void
    {
        if (empty($files)) {
            return;
        }

        $tree = $this->buildTree($files);

        $this->renderTree($tree, '', true, $highlightMap);
    }

    /**
     * Build an in-memory tree from file paths
     */
    private function buildTree(array $files): array
    {
        $tree = [];

        foreach ($files as $file) {
            $relative = ltrim(
                str_replace(base_path(), '', $file),
                DIRECTORY_SEPARATOR
            );

            $parts = explode(DIRECTORY_SEPARATOR, $relative);
            $current = &$tree;

            foreach ($parts as $part) {
                if (! isset($current[$part])) {
                    $current[$part] = [];
                }
                $current = &$current[$part];
            }
        }

        return $tree;
    }

    /**
     * Recursively render tree
     */
    private function renderTree(
        array $tree,
        string $prefix,
        bool $isRoot,
        array $highlightMap
    ): void {
        $keys = array_keys($tree);
        $lastIndex = count($keys) - 1;

        foreach ($keys as $index => $key) {
            $isLast = $index === $lastIndex;

            $connector = $isRoot
                ? '├── '
                : ($isLast ? '└── ' : '├── ');

            $display = $this->colorize($key, $highlightMap);

            $this->output->writeln($prefix . $connector . $display);

            if (! empty($tree[$key])) {
                $newPrefix = $prefix . ($isLast ? '    ' : '│   ');
                $this->renderTree(
                    $tree[$key],
                    $newPrefix,
                    false,
                    $highlightMap
                );
            }
        }
    }

    /**
     * Apply color based on highlight map
     */
    private function colorize(string $name, array $highlightMap): string
    {
        foreach ($highlightMap as $key => $color) {
            if (str_contains($name, $key)) {
                return "<fg={$color}>{$name}</>";
            }
        }

        return $name;
    }
}
