<?php

namespace App\Console\Commands;

use App\Exports\NiuniuOrderExport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ExportNiuniuOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'niuniu:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $month = 9;
        $startDate = '2024-01-01';
        $endDate = '2024-01-31';
        $userIds = [1,2];
        return Excel::store(new NiuniuOrderExport($month, $startDate, $endDate, $userIds), 'users.xlsx');
    }
}
