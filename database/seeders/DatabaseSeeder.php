<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Administration;
use App\Models\Campaign;
use App\Models\City;
use App\Models\Donation;
use App\Models\Employee;
use App\Models\Evaluation;
use App\Models\News;
use App\Models\NewsImage;
use App\Models\Section;
use App\Models\User;
use App\Models\Wallet;
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
    private function employee()
    {
        Employee::insert([[
            'first_name' => 'MM',
            'last_name' => 'MM',
            'father_name' => 'MM',
            'mother_name' => 'MM',
            'phone_number' => '0936287134',
            'id_serial_number' => '03280000000',
            'nationality' => 'سوري',
            'birth_date' => '2000-12-08',
            'city_id' => 1,
            'address' => 'بأخر الدنيا',
            'academic_level' => 'جامعي',
            'academic_specialization' => 'الهندسة المعلوماتية',
            'social_situation' => 'أعزب',
            'section_id' => 1,
            'date_start_working' => '2020-12-12',
            'date_end_working' => null,
            'image' => 'Employee/image.png'
        ]]);
    }
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->rolesAndPermissions();
        $this->section();
        $this->city();
        $this->employee();

        Administration::factory(1)->create();
        NewsImage::factory(10)->create();
        Campaign::factory(4)->create();
        Employee::factory(5)->create();
        User::factory(5)->create();
        Wallet::factory(5)->create();
        Donation::factory(15)->create();
        Evaluation::factory(2)->create();
    }
}
