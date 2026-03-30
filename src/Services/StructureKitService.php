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
            try {
                $this->make(
                    'model.stub',
                    "{$paths['model']}/{$name}.php",
                    $paths['model'],
                    [
                        'model' => $name,
                    ]
                );
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("StructureKit Model Error: " . $e->getMessage());
            }
        }

        /*
        |--------------------------------------------------------------------------
        | REPOSITORY INTERFACE
        |--------------------------------------------------------------------------
        */
        if (in_array('repository_interface', $components)) {
            try {
                $this->make(
                    'repository-interface.stub',
                    "{$paths['repository_interface']}/{$name}RepositoryInterface.php",
                    $paths['repository_interface'],
                    [
                        'interface' => "{$name}RepositoryInterface",
                    ]
                );
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("StructureKit Repository Interface Error: " . $e->getMessage());
            }
        }

        /*
        |--------------------------------------------------------------------------
        | REPOSITORY IMPLEMENTATION
        |--------------------------------------------------------------------------
        */
        if (in_array('repository', $components)) {
            try {
                $this->make(
                    'repository.stub',
                    "{$paths['repository']}/{$name}Repository.php",
                    $paths['repository'],
                    [
                        'class' => "{$name}Repository",
                        'interface' => "{$name}RepositoryInterface",
                        'model' => $name,
                        'modelNamespace' => $this->modelNamespace($paths['model'], $name),
                        'repositoryInterfaceNamespace' => $this->ns($paths['repository_interface'] ?? '') . "\\{$name}RepositoryInterface"
                    ]
                );
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("StructureKit Repository Error: " . $e->getMessage());
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SERVICE INTERFACE
        |--------------------------------------------------------------------------
        */
        if (in_array('service_interface', $components)) {
            try {
                $this->make(
                    'service-interface.stub',
                    "{$paths['service_interface']}/{$name}ServiceInterface.php",
                    $paths['service_interface'],
                    [
                        'interface' => "{$name}ServiceInterface",
                    ]
                );
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("StructureKit Service Interface Error: " . $e->getMessage());
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SERVICE IMPLEMENTATION
        |--------------------------------------------------------------------------
        */
        if (in_array('service', $components)) {
            try {
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
                            ? $this->ns($paths['repository_interface'] ?? '') . "\\{$name}RepositoryInterface"
                            : '',
                        'model' => $name,
                        'modelNamespace' => $this->modelNamespace($paths['model'], $name),
                        'serviceInterfaceNamespace' => $this->ns($paths['service_interface'] ?? '') . "\\{$name}ServiceInterface"
                    ]
                );
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("StructureKit Service Error: " . $e->getMessage());
            }
        }

        /*
        |--------------------------------------------------------------------------
        | CONTROLLER
        |--------------------------------------------------------------------------
        */
        if (in_array('controller', $components)) {
            try {
                $service = in_array('service', $components);
                $this->make(
                    $service ? 'controller.stub' : 'controller-without-service.stub',
                    "{$paths['controller']}/{$name}Controller.php",
                    $paths['controller'],
                    [
                        'model' => $name,
                        'serviceInterface' => "{$name}ServiceInterface",
                        'serviceInterfaceNamespace' => $service ?
                            $this->ns($paths['service_interface'] ?? '') . "\\{$name}ServiceInterface"
                            : '',
                    ]
                );
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("StructureKit Controller Error: " . $e->getMessage());
            }
        }

        /*
        |--------------------------------------------------------------------------
        | MIGRATION
        |--------------------------------------------------------------------------
        */
        try {
            $timestamp = now()->format('Y_m_d_His');
            $fileName ='create_' . Str::snake(Str::plural($name)) . '_table';
            
            Artisan::call('make:migration', [
                'name' => $fileName,
            ]);

            // Track the last migration
            $lastMigration = "database/migrations/{$timestamp}_{$fileName}.php";
            $this->generatedFiles[] = $lastMigration;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("StructureKit Migration Error: " . $e->getMessage());
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
