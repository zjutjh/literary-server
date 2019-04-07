<?php

use App\Institute;
use Illuminate\Database\Seeder;

class InstitutesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $institutes = [
            '经贸管理学院',
            '计算机科学与技术学院',
            '信息工程学院',
            '药学院',
            '海洋学院',
            '外国语学院',
            '材料科学与工程学院',
            '长三角绿色制药协同创新中心',
            '化学工程学院',
            '艺术学院',
            '法学院',
            '国际学院',
            '健行学院',
            '理学院',
            '人文学院',
            '机械工程学院',
            '教育科学与技术学院',
            '政治与公共管理学院',
            '生物工程学院',
            '环境学院',
            '建筑工程学院'
        ];
        foreach ($institutes as $key => $value) {
            Institute::create([
                'name' => $value
            ]);
        }
    }
}
