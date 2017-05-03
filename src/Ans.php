<?php

namespace AnsAsia\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Carbon\Carbon;
class Ans extends Command
{
    /**
     * @author tannq@ans-asia.com
     * @var void
     */
    protected $file;

    /**
     * @author tannq@ans-asia.com
     * @var void
     */
    protected $date;

    /**
     * @author tannq@ans-asia.com
     * @var MakeModule
     */
    protected $generate;
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $file)
    {
        parent::__construct();
        $this->file = $file;
        $this->date = Carbon::now();
    }

    /**
     * if not exists Directory, make Directory with permission
     * @author tannq@ans-asia.com
     * @var null
     */
    public function createDirectoryIfNotExists($params,$permissions=null) 
    {
        // default permission 0644
        $permissions = $permissions ? $permissions : '0644';

        // if @params is array or string
        if(is_array($params)) 
        {
            $bar = $this->output->createProgressBar(count($params));
            $bar->setProgress(-1);
            foreach($params as $path)
            {
                sleep(1);
                $this->line("");
                $this->line("> Check directory [{$path}] exist ...");
                if(!$this->file->exists(app_path().'/'.$path)) 
                {
                    $this->file->makeDirectory(app_path().'/'.$path,$permissions,true);
                    $this->line("Ok!");
                } else {
                    $this->line("Ok!"); 
                }
                $bar->advance();
            }
            $bar->finish();
        } else {
            if(!$this->file->exists(app_path().'/'.$params)) {
                $this->file->makeDirectory(app_path().'/'.$params,$permissions,true);
                $this->line("Ok!");
            } else {
                $this->line("Ok!"); 
            }
        }
        
    }

    /**
     * get templates
     * @author tannq@ans-asia.com
     * @var string
     */
    public function getTemplate($templateFileName,$search=nul,$replace=null)
    {
        $template = $this->file->get(__DIR__.'/templates/'.$templateFileName.'.txt');

        return str_replace($search, $replace, $template);
    }

    /**
     * create file
     * @author tannq@ans-asia.com
     * @var string
     */
    public function createFile($file,$template,$replace=true)
    {
        if(!$this->file->exists($file)) 
        {
            $this->line("->Create file [{$file}]...");
            $this->line("Copy template to [{$file}]...");
            $this->file->put($file,$template);
            $this->info("Content file apply change.");
        } else {
            if($replace) {
                if ($this->confirm("->File [{$file}] already exists, replace the file in the destination? [y|N]")) 
                {
                    $this->line("Copy template to [{$file}]...");
                    $this->file->put($file,$template);
                    $this->info("> Content file apply change.");
                } 
            } 
        }
    }
}
