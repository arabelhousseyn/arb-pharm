<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Enlightn\SecurityChecker\SecurityChecker;
class SecurityCheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'security:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check security of app';

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
        $result = (new SecurityChecker)->check('composer.lock');
        return Command::SUCCESS;
    }
}
