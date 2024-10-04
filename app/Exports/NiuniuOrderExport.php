<?php

namespace App\Exports;

use App\Models\Niuniu\Order;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class NiuniuOrderExport implements WithMultipleSheets
{
    use Exportable;

    private $month;
    private $startDate;
    private $endDate;
    private $userIds;

    public function __construct($month, $startDate, $endDate, $userIds)
    {
        $this->month = $month;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->userIds = $userIds;
    }

    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new DailiangSheet($this->month, $this->startDate, $this->endDate, $this->userIds);
        $sheets[] = new NoDailiangSheet($this->month, $this->startDate, $this->endDate, $this->userIds);

        return $sheets;
    }
}
