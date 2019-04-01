<?php

namespace App\Console\Commands\Elasticsearch;

use Illuminate\Console\Command;

class CreateIndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:create-index {index}';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建一个es索引';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $es    = app('es');
        $index = $this->argument('index');
        if (!$es->indices()->exists(['index' => $index])) {
            $es->indices()->create([
                // 第一个版本的索引名后缀为 _0
                'index' => $index,
                'body'  => [
                    'mappings' => [
                        '_doc' => [
                            'properties'=>[
                                'title'   => ['type' => 'keyword'],
                                'content' => ['type' => 'keyword']
                            ]
                        ],
                    ],
                ],
            ]);
        }
    }
}
