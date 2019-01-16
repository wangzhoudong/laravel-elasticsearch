<?php

namespace Wangzd\ScoutES\Console;

use Illuminate\Console\Command;
use Wangzd\ScoutES\ESClientTrait;

class FlushCommand extends Command
{
    use ESClientTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elasticsearch:flush {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $class = $this->argument('model');
        $this->call('scout:flush', [
            'model' => $class
        ]);
        $model = new $class;
        $index = [
            'index' => config('scout.prefix').$model->searchableAs()
        ];
        $client = $this->getElasticsearchClient();
        $client->indices()->delete($index);
    }
}
