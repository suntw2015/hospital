<?php

namespace App\Console\Commands;

use App\Models\MaterialConfig;
use Illuminate\Console\Command;

class InitNiuNiuCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'niuniu';

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
        $this->initMaterialConfig();
    }

    private function initMaterialConfig()
    {
        $configString = "
意大利骨水泥 499 意大利 带量
PKP 1399 凯利泰 带量
PVP 799 凯利泰 带量
贺利氏MV+G水泥 517 贺利氏 带量
贺利氏R+G 517 贺利氏 带量
全膝 4598.98 爱康 带量
全髋 5390 爱康 带量
膝关节 245.66 爱康 带量
摆据 2842 百通 非带量
冲洗枪 2180 中诺恒康 非带量
一次性使用无菌脊柱定位手术工具包SS2 13500 天智航 非带量";

        $arr = explode("\n", $configString);
        $data = [];
        foreach ($arr as $index => $item) {
            if (empty($item)) {
                continue;
            }
            $detail = explode(" ", $item);
            if (count($detail) != 4) {
                printf("原始配置不对：".$item."---\n");
                exit;;
            }

            MaterialConfig::create([
                'name' => $detail[0],
                'type' => $detail[3] == '带量' ? 1 : 2,
                'unit_price' => $detail[1],
                'brand' => $detail[2],
                'status' => 0,
            ]);
        }
    }
}
