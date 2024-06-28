<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Administration;
use App\Models\BillingHistory;
use App\Models\Campaign;
use App\Models\City;
use App\Models\Donation;
use App\Models\DonationAlert;
use App\Models\DonationCampaign;
use App\Models\DonationCampaignAlert;
use App\Models\Employee;
use App\Models\Evaluation;
use App\Models\News;
use App\Models\NewsImage;
use App\Models\Section;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletCharge;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    private function rolesAndPermissions()
    {

        Role::insert([
            ['guard_name' => 'web', 'name' => 'super_admin', 'created_at' => now()],
            ['guard_name' => 'web', 'name' => 'admin', 'created_at' => now()],
            ['guard_name' => 'web', 'name' => 'employee', 'created_at' => now()]

        ]);
    }
    private function city()
    {
        City::insert([
            ['name' => 'دمشق'],
        ]);
    }
    private function section()
    {
        Section::insert([
            ['name' => 'التنمية الإدارية'],
            ['name' => 'الإعلام'],
            ['name' => 'المخزن'],
            ['name' => 'المحاسبة'],
            ['name' => 'الكفلاء'],
            ['name' => 'طلاب العلم'],
            ['name' => 'الأيتام'],
            ['name' => 'كبار السن'],
            ['name' => 'الأسر المتعففة'],
        ]);
    }
    private function employeeAndAccount()
    {
        Employee::insert([[
            'first_name' => 'ادمن',
            'last_name' => 'ادمن',
            'father_name' => 'اسم الاب',
            'mother_name' => 'اسم الام',
            'phone_number' => '0900000000',
            'id_serial_number' => '00000000000',
            'nationality' => 'سوري',
            'birth_date' => '2000-01-01',
            'city_id' => 1,
            'address' => 'عنوان',
            'academic_level' => 'جامعي',
            'academic_specialization' => 'الهندسة المعلوماتية',
            'social_situation' => 'أعزب',
            'section_id' => 1,
            'date_start_working' => '2020-12-12',
            'date_end_working' => null,
            'image' => 'Employee/image.png'
        ]]);

        Administration::insert([
            'employee_id' => 1,
            'user_name' => 'admin',
            'password' => bcrypt('password')
        ]);
    }
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->rolesAndPermissions();
        $this->section();
        $this->city();
        $this->employeeAndAccount();

        Administration::factory(5)->create();
        //Employee::factory(5)->create();
        Evaluation::factory(2)->create();
        Campaign::factory(4)->create();
        //News::factory(10)->create();
        NewsImage::factory(10)->create();

        User::factory(5)->create();
        Wallet::factory(5)->create();
        
        //WalletCharge::factory(20)->create();
        //Donation::factory(15)->create();
        //DonationCampaign::factory(15)->create();

        BillingHistory::factory(5)->create();
        DonationAlert::factory(4)->create();
        DonationCampaignAlert::factory(4)->create();
    }
}
