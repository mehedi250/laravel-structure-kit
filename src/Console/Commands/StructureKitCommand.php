<?php

namespace StructureKit\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use StructureKit\Helpers\TreePrinter;
use StructureKit\Services\StructureKitService;

class StructureKitCommand extends Command
{
    protected $signature = 'structure-kit
                            {name : Model or module name}
                            {flags? : m c s r t}
                            {--model : Generate model}
                            {--controller : Generate controller}
                            {--service : Generate service (interface + class)}
                            {--repository : Generate repository (interface + class)}
                            {--migration : Generate migration}
                            {--dry-run : Preview without creating files}
                            {--force : Overwrite existing files}';

    protected $description = 'Generate Laravel structure using flags or options (m c s r t)';

    protected StructureKitService $service;

    public function __construct(StructureKitService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function handle(): int
    {
        $name = Str::studly($this->argument('name'));
        $flags = strtolower($this->argument('flags') ?? '');

        // Parse components from flags + explicit options
        $components = $this->parseFlags($flags);

        if ($this->option('model'))
            $components[] = 'model';
        if ($this->option('controller'))
            $components[] = 'controller';
        if ($this->option('service')) {
            $components[] = 'service';
            $components[] = 'service_interface';
        }
        if ($this->option('repository')) {
            $components[] = 'repository';
            $components[] = 'repository_interface';
        }
        if ($this->option('migration'))
            $components[] = 'migration';

        $components = array_unique($components);

        if (empty($components)) {
            $this->error('❌ No components selected. Use flags (mcsrt) or options (--service)');
            return self::FAILURE;
        }

        // Default CLI paths
        $paths = [
            'model' => 'app/Models',
            'controller' => 'app/Http/Controllers',
            'service' => 'app/Services/Implementations',
            'service_interface' => 'app/Services/Contracts',
            'repository' => 'app/Repositories/Eloquent',
            'repository_interface' => 'app/Repositories/Contracts',
        ];

        $highlight = [
            'Models' => 'green',
            'Controllers' => 'blue',
            'Services' => 'cyan',
            'Contracts' => 'yellow',
            'Repositories' => 'magenta',
            'migrations' => 'red',
        ];
        if (!$this->option('dry-run')) {
            $this->service->generateFromUI([
                'name' => $name,
                'components' => $components,
                'paths' => $paths,
                'extra' => [
                    'dry-run' => $this->option('dry-run'),
                    'force' => $this->option('force'),
                ],
            ]);
            $generated = $this->service->generatedFiles;

            $this->info("\n📂 Generated Structure:\n");

            $tree = new TreePrinter();
            $tree->printFiles($generated, $highlight);
        } else {
            $generated = [];
            $this->info("\n📂 Possible file paths:\n");
            if (isset($components['model']))
                $generated[] = $paths['model'] . "/" . $name . ".php";
            if (isset($components['controller']))
                $generated[] = $paths['controller'] . "/" . $name . "Controller.php";
            if (isset($components['service']))
                $generated[] = $paths['service'] . "/" . $name . "Service.php";
            if (isset($components['service_interface']))
                $generated[] = $paths['service_interface'] . "/" . $name . "ServiceInterface.php";
            if (isset($components['repository']))
                $generated[] = $paths['repository'] . "/" . $name . "Repository.php";
            if (isset($components['repository_interface']))
                $generated[] = $paths['repository_interface'] . "/" . $name . "RepositoryInterface.php";
            if (isset($components['migration'])) {
                $timestamp = now()->format('Y_m_d_His');
                $generated[] = "database/migrations/{$timestamp}_create_" . strtolower($name) . "_table.php";
            }

            $this->info("\n📂 Possible file paths:\n");
            $tree = new TreePrinter();
            $tree->printFiles($generated, $highlight);
        }

        $this->info('✅ Structure generated successfully!');
        $this->info('Generated: ' . implode(', ', $components));

        return self::SUCCESS;
    }

    private function parseFlags(string $flags): array
    {
        $map = [
            'm' => 'model',
            'c' => 'controller',
            's' => 'service',
            'r' => 'repository',
            't' => 'migration',
        ];

        $components = [];

        foreach (str_split($flags) as $flag) {
            if (!isset($map[$flag]))
                continue;

            $components[] = $map[$flag];

            // Automatically add interfaces
            if ($flag === 's')
                $components[] = 'service_interface';
            if ($flag === 'r')
                $components[] = 'repository_interface';
        }

        return array_unique($components);
    }
}
