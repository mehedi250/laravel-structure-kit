<?php

namespace StructureKit\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use StructureKit\Generators\StructureGenerator;

class StructureKitService
{
    public array $generatedFiles = [];
    protected $generator;

    public function __construct(StructureGenerator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Main entry from Controller
     */
    public function generateFromUI(array $data): void
    {
        $name = Str::studly($data['name']);
        $components = $data['components'] ?? [];
        $paths = $data['paths'] ?? [];

        /*
        |--------------------------------------------------------------------------
        | MODEL
        |--------------------------------------------------------------------------
        */
        if (in_array('model', $components)) {
            $this->make(
                'model.stub',
                "{$paths['model']}/{$name}.php",
                $paths['model'],
                [
                    'model' => $name,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | REPOSITORY INTERFACE
        |--------------------------------------------------------------------------
        */
        if (in_array('repository_interface', $components)) {
            $this->make(
                'repository-interface.stub',
                "{$paths['repository_interface']}/{$name}RepositoryInterface.php",
                $paths['repository_interface'],
                [
                    'interface' => "{$name}RepositoryInterface",
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | REPOSITORY IMPLEMENTATION
        |--------------------------------------------------------------------------
        */
        if (in_array('repository', $components)) {
            $this->make(
                'repository.stub',
                "{$paths['repository']}/{$name}Repository.php",
                $paths['repository'],
                [
                    'class' => "{$name}Repository",
                    'interface' => "{$name}RepositoryInterface",
                    'model' => $name,
                    'modelNamespace' => $this->modelNamespace($paths['model'], $name),
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | SERVICE INTERFACE
        |--------------------------------------------------------------------------
        */
        if (in_array('service_interface', $components)) {
            $this->make(
                'service-interface.stub',
                "{$paths['service_interface']}/{$name}ServiceInterface.php",
                $paths['service_interface'],
                [
                    'interface' => "{$name}ServiceInterface",
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | SERVICE IMPLEMENTATION
        |--------------------------------------------------------------------------
        */
        if (in_array('service', $components)) {
            $usesRepository = in_array('repository', $components);

            $this->make(
                $usesRepository
                ? 'service.stub'
                : 'service-without-repo.stub',
                "{$paths['service']}/{$name}Service.php",
                $paths['service'],
                [
                    'class' => "{$name}Service",
                    'interface' => "{$name}ServiceInterface",
                    'repositoryInterface' => "{$name}RepositoryInterface",
                    'repositoryInterfaceNamespace' =>
                        $usesRepository
                        ? $this->ns($paths['repository_interface']) . "\\{$name}RepositoryInterface"
                        : '',
                    'model' => $name,
                    'modelNamespace' => $this->modelNamespace($paths['model'], $name),
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CONTROLLER
        |--------------------------------------------------------------------------
        */
        if (in_array('controller', $components)) {
            $this->make(
                'controller.stub',
                "{$paths['controller']}/{$name}Controller.php",
                $paths['controller'],
                [
                    'model' => $name,
                    'serviceClass' => "{$name}ServiceInterface",
                    'serviceNamespace' =>
                        $this->ns($paths['service_interface']) . "\\{$name}ServiceInterface",
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | MIGRATION
        |--------------------------------------------------------------------------
        */
        Artisan::call('make:migration', [
            'name' => 'create_' . Str::snake(Str::plural($name)) . '_table',
        ]);

        // Track the last migration
        $lastMigration = collect(glob(database_path('migrations/*.php')))
            ->sortByDesc(fn($f) => filemtime($f))
            ->first();

        if ($lastMigration) {
            $this->generatedFiles[] = $lastMigration;
        }
    }

    /**
     * Wrapper around generator
     */
    private function make(
        string $stub,
        string $file,
        string $path,
        array $vars
    ): void {
        $fullPath = base_path($file);

        $this->generator->generateFromStub(
            $stub,
            $fullPath,
            array_merge([
                'namespace' => $this->ns($path),
            ], $vars)
        );
        $this->generatedFiles[] = $fullPath;
    }

    /**
     * Convert path to namespace
     */
    private function ns(string $path): string
    {
        $path = trim($path, '/');
        $path = str_replace(['/', '\\'], '\\', $path);

        if (Str::startsWith($path, 'app\\')) {
            return 'App\\' . Str::after($path, 'app\\');
        }

        return 'App\\' . $path;
    }

    /**
     * Build model namespace
     */
    private function modelNamespace(string $modelPath, string $model): string
    {
        return $this->ns($modelPath) . "\\{$model}";
    }
}
