<?php

use Illuminate\Database\Seeder;
use Katniss\Everdeen\Models\MetaInput;
use Katniss\Everdeen\Utils\AppConfig;

class CertificateDefSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $certificates = [
            'IELTS',
            'TOEFL',
            'TOEIC',
            'ESL',
        ];

        $order = 0;
        foreach ($certificates as $type) {
            $metaInput = new MetaInput();
            $metaInput->order = ++$order;
            $metaInput->type = MetaInput::TYPE_CERTIFICATE_DEF;
            $metaInput->name = $type;
            $metaInput->save();
        }
    }
}
