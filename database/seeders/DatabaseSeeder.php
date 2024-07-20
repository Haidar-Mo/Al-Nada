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
use App\Models\kitchen;
use App\Models\News;
use App\Models\NewsImage;
use App\Models\Product;
use App\Models\Report;
use App\Models\Section;
use App\Models\User;
use App\Models\Volunteer;
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

        Administration::find(1)->assignRole('admin');
    }

    private function campaign()
    {

        Campaign::insert([
            [
                'id' => 1,
                'name' => 'سلات رمضان',
                'description' => 'تفتتح جمعية الندى حملة "سلات رمضان" لعام 2025، بهدف مساعدة العائلات المحتاجة في المنطقة على استقبال شهر رمضان المبارك بشكل مريح وكريم.\r\nتهدف هذه الحملة إلى توزيع سلات غذائية مجانية على الأسر ذات الدخل المحدود، والتي تحتاج إلى المساعدة خلال هذا الشهر. تحتوي السلة على مجموعة متنوعة من المواد الغذائية الأساسية و هي الأرز والسكر والزيت والعدس والحليب والمعكرونة و معلبات (مرتديلا/طون/سردين)، بما يكفي لتغطية معظم احتياجات الأسرة طوال شهر رمضان.\r\nمن خلال هذه المبادرة، تسعى جمعية الندى إلى تخفيف الأعباء المالية عن كاهل الأسر المحتاجة، وإتاحة الفرصة لهم لقضاء شهر رمضان في جو من الراحة والبركة، دون القلق على توفير الاحتياجات الأساسية.\r\nقيمة السلة : 600 الف ليرة سورية\r\nملاحظة : يمكن للمؤسسات التجارية أو الأهلية الراغبة في المساهمة في هذه الحملة التواصل مع الجمعية على الأرقام المعلنة أو زيارة المكتب الرئيسي للجمعية.',
                'cost' => '0.00',
                'number_of_Beneficiary' => '0',
                'is_donateable' => 1,
                'is_volunteerable' => 0,
                'image' => 'Campaign/سلات رمضان.jpg',
                'start_date' => '2024-06-13',
                'end_date' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'دفء الشتاء',
                'description' => 'انطلاقًا من مسؤوليتها الاجتماعية، تطلق جمعية الندى حملة "دفء الشتاء" لعام 2025.\r\nتأتي هذه الحملة في إطار جهود الجمعية لدعم الأسر المتعففة والتخفيف من معاناتهم خلال فصل الشتاء. فالملابس الشتوية الدافئة هي ضرورة أساسية لحماية الأفراد من البرد القارص، ولكن للأسف لا تستطيع بعض الأسر توفير هذه الاحتياجات نظرًا لظروفها المادية الصعبة.\r\nمن خلال هذه الحملة، ستقوم الجمعية بجمع التبرعات من الأفراد والشركات لشراء ملابس شتوية جديدة، ثم توزيعها على العائلات المحتاجة.\r\nالحد الأدنى للتبرع : 200 الف ليرة سورية',
                'cost' => '0.00',
                'number_of_Beneficiary' => '0',
                'is_donateable' => 1,
                'is_volunteerable' => 0,
                'image' => 'Campaign/دفء الشتاء.jpg',
                'start_date' => '2024-06-13',
                'end_date' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'name' => 'أضاحي العيد',
                'description' => 'تطلق جمعية الندى حملة "أضاحي العيد" لعام 2025، بهدف توزيع حصص لحم على الأسر المتعففة.\r\nإن عيد الأضحى هو مناسبة دينية وأخلاقية عظيمة، تؤكد على قيم التكافل والتراحم بين أفراد المجتمع. ولكن للأسف، لا تستطيع بعض العائلات الاحتفال بالعيد بشكل كامل.\r\nمن خلال هذه الحملة، نسعى إلى إدخال البهجة والسرور على قلوب هذه العائلات، ومساعدتهم على الاحتفال بعيدهم بفرح وسعادة. فكل مساهمة ستساعد في وضع لحم الأضحية على موائد هذه الأسر المحتاجة.\r\nقيمة الحصة الواحدة : 100 الف ليرة سورية',
                'cost' => '0.00',
                'number_of_Beneficiary' => '0',
                'is_donateable' => 1,
                'is_volunteerable' => 0,
                'image' => 'Campaign/أضاحي العيد.jpg',
                'start_date' => '2024-06-13',
                'end_date' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'name' => 'حقيبة الأمل',
                'description' => 'تطلق جمعية الندى حملة "حقيبة الأمل" لعام 2025، بهدف مساعدة الطلاب المحتاجين في الحصول على مستلزمات التعليم الأساسية التي يحتاجونها لبداية العام الدراسي الجديد.\r\nمهام المتطوع: توضيب القرطاسية ضمن الحقائب.\r\nمكان العمل : ضمن مقر الجمعية الرئيسي في المزة.\r\nالأيام : من 10 إلى 25 آب \r\nالوقت: من الساعة العاشرة صباحاً إلى الواحدة ظهراً',
                'cost' => '0.00',
                'number_of_Beneficiary' => '0',
                'is_donateable' => 1,
                'is_volunteerable' => 1,
                'image' => 'Campaign/حقيبة الأمل.jpg',
                'start_date' => '2024-06-13',
                'end_date' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 5,
                'name' => 'ملابس العيد',
                'description' => 'تطلق جمعية الندى حملة "ملابس العيد" لعام 2025، بهدف مساعدة العوائل المستحقة على تأمين ملابس جديدة لأطفالهم في العيد.\r\nمهام المتطوع: فرز الملابس و توضيبها.\r\nمكان العمل : ضمن مقر الجمعية الرئيسي في المزة.\r\nالأيام : من 10 إلى 25 حزيران.\r\nالوقت: من الساعة العاشرة صباحاً إلى الواحدة ظهراً',
                'cost' => '0.00',
                'number_of_Beneficiary' => '0',
                'is_donateable' => 0,
                'is_volunteerable' => 1,
                'image' => 'Campaign/ملابس العيد.jpg',
                'start_date' => '2024-06-13',
                'end_date' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    private function newsWithImages()
    {
        News::insert([
            [
                'id' => 1,
                'title' => 'يوم مميز لسيدات المشاريع الصغيرة',
                'description' => 'يوم مميز للمستفيدات المتميزات في جمعية الندى سواء المشاريع الصغيرة أو حضور المحاضرات التوعوية أو الالتزام بالنادي الصيفي في إحدى منتزهات الربوة ..\nعبارة عن مسابقات متنوعة تشجيعية وتقديم جوائز تحفيزية ووجبة غداء ( صفيحة وكبة مقلية وبرك ولبن عيران) مع ضيافة حلو..\nبحضور كريم من بعض عضوات مجلس الإدارة ومشرفات لجنة التنمية ..\nكل الشكر للجهود المبذولة والمتبرعين والداعمين.. \nدمتم ودام عطاؤكم.\nساهموا معنا بدعم المشاريع الصغيرة \nللتبرع بمقر جمعية الندى مزة اتوستراد نزلة جامع الأكرم بعد السفارة الأوكرانية',
                'created_at' => '2024-06-04 07:53:19',
                'updated_at' => '2024-06-04 07:53:19',
            ],
            [
                'id' => 2,
                'title' => 'احتفال باليوم العالمي للتوحد',
                'description' => 'احتفالاً باليوم العالمي للتوحد وتاكيداً على أهمية التوعية\nعن التنمر.\nشارك بعض من أطفال جمعية الندى بمركز المليحة المجتمعي بفرح بالأنشطة الترفيهية والحركية النفسية. \nبالإضافة لتقديم برنامج الرعاية الشاملة لذوي الإعاقة لبرامج تدريبية تساهم في تنمية قدرات الأطفال ومقدمي الرعاية..\nقسم الدعم النفسي الاجتماعي',
                'created_at' => '2024-06-04 07:53:19',
                'updated_at' => '2024-06-04 07:53:19',
            ],
            [
                'id' => 3,
                'title' => 'يوم مميز لأطفال الجمعية',
                'description' => 'وم مرح استمتع به بعض من أطفال جمعية الندى\n في مطعم البيت السويسري..\nتم فيه ألعاب ومسابقات ووجبة غداء وجوائز نقدية..\nكل الشكر لإدارة المطعم على حسن الاستقبال وكرم الضيافة لأطفالنا...\nلجنة اليتيم\nبدعمكم نستمر\nللتبرع بكفالة اليتيم بمقر جمعية الندى مزة اتوستراد نزلة جامع الأكرم بعد السفارة الاوكرانية',
                'created_at' => '2024-06-04 07:53:19',
                'updated_at' => '2024-06-04 07:53:19',
            ],
            [
                'id' => 4,
                'title' => 'همة حتى القمة',
                'description' => 'همة حتى القمة..  شعار التميز لهذا العام أطلقته جمعية الندى\nلجنة طالب العلم الجامعي لتفوق عدد من الطلاب والطالبات في اختصاصتهم  الجامعية..\nفكرمتهم بيوم ساده الفرح تقديراً لتميزهم رغم ظروفهم الخاصة.. بحضور كريم من مجلس إدارة جمعية الندى.. \nكل الشكر لجهودكم المبذولة ولعطائكم المستمر..\nدمتم ودامت أياديكم البيضاء..\nلجنة طالب العلم الجامعي',
                'created_at' => '2024-06-04 07:53:19',
                'updated_at' => '2024-06-04 07:53:19',
            ],
            [
                'id' => 5,
                'title' => 'يوم الفضاء العالمي',
                'description' => 'بمناسبة يوم الفضاء العالمي \nلبت جمعية الندى دعوة المركز الثقافي الروسي بالتعاون مع سفيرة النوايا الحسنة للطفولة..\nفتم عرض فيلم وثائقي عن رائد الفضاء وتحفيز الإبداع من خلال رسومات للأطفال وتقديم هدايا تشجيعية أدخلت البهجة والفرح على قلوب الأطفال..\nكل الشكر للقائمين على هذه الدعوة الكريمة لأطفال الندى المشاركين 320 طفل وطفلة.\nبدعمكم نستمر\nمجلس إدارة جمعية الندى',
                'created_at' => '2024-06-04 07:53:19',
                'updated_at' => '2024-06-04 07:53:19',
            ],
        ]);

        NewsImage::insert([
            [
                'id' => 1,
                'news_id' => 1,
                'url' => 'News/المشاريع الصغيرة1.jpg',
                'created_at' => '2024-06-04 07:53:19',
                'updated_at' => '2024-06-04 07:53:19',
            ],
            [
                'id' => 2,
                'news_id' => 1,
                'url' => 'News/المشاريع الصغيرة2.jpg',
                'created_at' => '2024-06-04 07:53:19',
                'updated_at' => '2024-06-04 07:53:19',
            ],
            [
                'id' => 3,
                'news_id' => 2,
                'url' => 'News/اطفال1.jpg',
                'created_at' => '2024-06-04 07:53:19',
                'updated_at' => '2024-06-04 07:53:19',
            ],
            [
                'id' => 4,
                'news_id' => 2,
                'url' => 'News/اطفال2.jpg',
                'created_at' => '2024-06-04 07:53:19',
                'updated_at' => '2024-06-04 07:53:19',
            ],
            [
                'id' => 5,
                'news_id' => 3,
                'url' => 'News/اطفال3.jpg',
                'created_at' => '2024-06-04 07:53:19',
                'updated_at' => '2024-06-04 07:53:19',
            ],
            [
                'id' => 6,
                'news_id' => 4,
                'url' => 'News/طلاب1.jpg',
                'created_at' => '2024-06-04 07:53:19',
                'updated_at' => '2024-06-04 07:53:19',
            ],
            [
                'id' => 7,
                'news_id' => 4,
                'url' => 'News/طلاب2.jpg',
                'created_at' => '2024-06-04 07:53:19',
                'updated_at' => '2024-06-04 07:53:19',
            ],
            [
                'id' => 8,
                'news_id' => 5,
                'url' => 'News/فضاء1.jpg',
                'created_at' => '2024-06-04 07:53:19',
                'updated_at' => '2024-06-04 07:53:19',
            ],
            [
                'id' => 9,
                'news_id' => 5,
                'url' => 'News/فضاء2.jpg',
                'created_at' => '2024-06-04 07:53:19',
                'updated_at' => '2024-06-04 07:53:19',
            ],
            [
                'id' => 10,
                'news_id' => 5,
                'url' => 'News/فضاء3.jpg',
                'created_at' => '2024-06-04 07:53:19',
                'updated_at' => '2024-06-04 07:53:19',
            ],
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
        $this->campaign();
        $this->employeeAndAccount();
        $this->newsWithImages();
        
        //Administration::factory(5)->create();
        //Employee::factory(5)->create();
        //Evaluation::factory(2)->create();
        //Campaign::factory(4)->create();
        
        //News::factory(10)->create();
        //NewsImage::factory(10)->create();
        
        User::factory(5)->create();
        Wallet::factory(5)->create();
        Donation::factory(15)->create();
        
        //WalletCharge::factory(20)->create();
        //DonationCampaign::factory(15)->create();
        
        BillingHistory::factory(5)->create();
        DonationAlert::factory(4)->create();
        DonationCampaignAlert::factory(4)->create();
        Volunteer::factory(10)->create();
        Report::factory(5)->create();
        
        Product::factory(5)->create();
        kitchen::factory(5)->create();
        
    }
}
