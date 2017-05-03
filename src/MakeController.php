<?php

namespace AnsAsia\Commands;
use AnsAsia\Commands\Ans;
use Illuminate\Filesystem\Filesystem;
use Carbon\Carbon;
class MakeController extends Ans
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ans:controller {--module=} {--name=} {--namespace=App\Modules} {--auth} {--alias=Modules}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make module controller';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $module = $this->option('module');
        $name = $this->option('name');
        $name = str_replace(['Controller','controller'], ['',''], $name);
        $namespace = $this->option('namespace');
        $alias = $this->option('alias');
        $auth = $this->option('auth');

        $module =  ucwords($module);
        $name =  ucwords($name);
        $namespace =  ucwords($namespace);
        $alias =  ucwords($alias);

        $this->createDirectoryIfNotExists("{$alias}/{$module}",$permissions=null);

        $moduleController = app_path("{$alias}/{$module}/Controllers/{$name}Controller.php");
        $moduleControllerTemplate = $this->getTemplate(
            "Controller",
            ["{{MODULE}}","{{NAME}}","{{NAMESPACE}}","{{NOW}}","{{AUTH}}"],
            ["{$module}","{$name}","{$namespace}","{$this->date}",$auth]
        );
        $this->createFile($moduleController,$moduleControllerTemplate,false);
    }
}
