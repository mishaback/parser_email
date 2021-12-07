<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EmailToCrm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parsing mail and adding to crm';

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
     * @return int
     */
    public function handle()
    {



        return Command::SUCCESS;
    }
}
