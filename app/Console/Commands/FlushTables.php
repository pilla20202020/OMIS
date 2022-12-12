<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FlushTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:flush-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush all the tables';

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
        try {
            $query = "SELECT table_name FROM information_schema.tables WHERE table_schema = 'company';";
            $tables = DB::select($query);
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            foreach($tables as $table){
                DB::table($table->table_name)->truncate();
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $this->comment(PHP_EOL . 'All the tables are flushed.' . PHP_EOL);
        } catch (\Exception $e) {
            $this->comment(PHP_EOL . $e->getMessage() . PHP_EOL);
        }
        // return 0;
    }
}
