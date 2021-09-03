<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateDocumentation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docs:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the documentation';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $openapi = \OpenApi\scan('app');
        $openapi->validate();
        $openapi->saveAs(public_path('apidoc/swagger.json'), 'json');

        $this->output->writeln('api generated');
    }
}
