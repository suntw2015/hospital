<?php

namespace App\Console\Commands;

use App\Enums\NiuniuConfigEnum;
use App\Models\MaterialConfig;
use App\Models\Niuniu\MaterialConfig as NiuniuMaterialConfig;
use App\Models\Niuniu\NiuniuConfig;
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
        $this->initOtherConfig();
    }

    private function initMaterialConfig()
    {
        $configString = "
冲洗枪	冲洗枪	非	2180	中诺恒康
一次性双极射频等离子体手术电极（MC301);双极射频电极（RC201D）	UBE	非	24000	邦士
一次性电池供电骨组织手术设备	摆据	非	2842	百通
一次性使用无菌脊柱定位手术工具包SS2	机器人	非	13500	天智航
骨水泥套装	骨水泥	带量	499	意大利
骨水泥R+G	骨水泥	带量	517	贺利氏
凯利泰PKP球囊	PKP	带量	1399	凯利泰
凯利泰PVP球囊	PVP	带量	799	凯利泰
全髋关节	髋关节	带量	5390	爱康
全膝关节	膝关节	带量	3098.98	爱康";

        $arr = explode("\n", $configString);
        $data = [];
        foreach ($arr as $index => $item) {
            if (empty($item)) {
                continue;
            }
            $detail = explode("	", $item);
            if (count($detail) != 5) {
                printf("原始配置不对：".$item."---\n");
                exit;;
            }

            NiuniuMaterialConfig::create([
                'name' => $detail[0],
                'short_name' => $detail[1],
                'type' => $detail[2] == '带量' ? 1 : 2,
                'unit_price' => $detail[3],
                'brand' => $detail[4],
            ]);
        }
    }

    public function initOtherConfig()
    {
        $doctors = "
李树明
肖凯
李永军
赵振达
王宇峰
梁伯冉
包同新
宋光泽
范喜文
李青松
        ";

        $doctors = explode("\n", $doctors);
        foreach ($doctors as $doctor) {
            if (empty($doctor)) {
                continue;
            }
            NiuniuConfig::create([
                'type' => NiuniuConfigEnum::TYPE_DOCTOR,
                'value' => $doctor
            ]);
        }

        $follows = "
常艳丽
管正林
张光辉
        ";
        $follows = explode("\n", $follows);
        foreach ($follows as $follow) {
            if (empty($follow)) {
                continue;
            }
            NiuniuConfig::create([
                'type' => NiuniuConfigEnum::TYPE_FOLLOW_USER,
                'value' => $follow
            ]);
        }
    }
}
