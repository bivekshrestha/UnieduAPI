<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * @var array
     */
    protected $settings = [
        [
            'key' => 'site_name',
            'value' => 'Uniedu.io',
        ],
        [
            'key' => 'site_title',
            'value' => 'Uniedu',
        ],
        [
            'key' => 'default_email_address',
            'value' => 'admin@admin.com',
        ],
        [
            'key' => 'currency_code',
            'value' => 'GBP',
        ],
        [
            'key' => 'currency_symbol',
            'value' => '£',
        ],
        [
            'key' => 'site_logo',
            'value' => '',
        ],
        [
            'key' => 'site_favicon',
            'value' => '',
        ],
        [
            'key' => 'footer_copyright_text',
            'value' => '',
        ],
        [
            'key' => 'seo_meta_title',
            'value' => '',
        ],
        [
            'key' => 'seo_meta_description',
            'value' => '',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->settings as $index => $setting) {
            $result = Setting::create($setting);
            if (!$result) {
                $this->command->info("Insert failed at record $index.");
                return;
            }
        }
        $this->command->info('Inserted ' . count($this->settings) . ' records');
    }
}
