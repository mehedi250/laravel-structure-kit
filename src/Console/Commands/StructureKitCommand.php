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

        if ($this->option('dry-run')) {
            $generated = [];
            if (in_array('model', $components))
                $generated[] = $paths['model'] . "/{$name}.php";
            if (in_array('controller', $components))
                $generated[] = $paths['controller'] . "/{$name}Controller.php";
            if (in_array('service', $components))
                $generated[] = $paths['service'] . "/{$name}Service.php";
            if (in_array('service_interface', $components))
                $generated[] = $paths['service_interface'] . "/{$name}ServiceInterface.php";
            if (in_array('repository', $components))
                $generated[] = $paths['repository'] . "/{$name}Repository.php";
            if (in_array('repository_interface', $components))
                $generated[] = $paths['repository_interface'] . "/{$name}RepositoryInterface.php";
            if (in_array('migration', $components)) {
                $timestamp = now()->format('Y_m_d_His');
                $generated[] = "database/migrations/{$timestamp}_create_" . Str::snake(Str::plural($name)) . "_table.php";
            }

            $this->info("\n📂 Possible file paths (dry-run):\n");
            $tree = new TreePrinter();
            $tree->printFiles($generated, $highlight);

            return self::SUCCESS;
        }

        $this->service->generateFromUI([
            'name' => $name,
            'components' => $components,
            'paths' => $paths,
            'extra' => [
                'force' => $this->option('force'),
            ],
        ]);

        $generated = $this->service->generatedFiles;

        $this->info("\n📂 Generated Structure:\n");
        $tree = new TreePrinter();
        $tree->printFiles($generated, $highlight);

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

            if ($flag === 's')
                $components[] = 'service_interface';
            if ($flag === 'r')
                $components[] = 'repository_interface';
        }

        return array_unique($components);
    }
}
