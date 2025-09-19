<?php

namespace App\Console\Commands;

use App\Models\Absen;
use Illuminate\Console\Command;

class rawQuery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:raw-query';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        Absen::truncate();
        $this->info('Query Executed');
    }
}
