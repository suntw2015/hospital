<?php

namespace App\Exports;

use App\Services\Niuniu\OrderService;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class DailiangSheet implements FromArray, WithTitle, WithHeadings, WithColumnFormatting
{
    private $month;
    private $startDate;
    private $endDate;
    private $userIds;
    private $orderService;

    public function __construct($month, $startDate, $endDate, $userIds)
    {
        $this->month = $month;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->userIds = $userIds;
    }

    public function array() : array
    {
        $this->orderService = app(OrderService::class);
        return $this->orderService->exportList($this->startDate, $this->endDate, $this->userIds, 1);
    }
    /**
     * @return string
     */
    public function title(): string
    {
        return $this->month.'月带量产品';
    }

    public function headings(): array
    {
        return [
            '序号',
            '日期',
            '患者',
            '住院号',
            '性别',
            '年龄',
            '医生',
            '种类',
            '计费',
            '品牌',
            '备注',
            '开票金额',
            '跟台人',
            '业绩',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}