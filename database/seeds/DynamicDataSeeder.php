<?php
use App\Models\area;
use App\Models\carBrands;
use App\Models\Carcolors;
use App\Models\Cardoors;

use App\Models\Carfules;
use App\Models\carModels;
use App\Models\Carseats;
use App\Models\Carshapes;
use App\Models\Carstatus;
use App\Models\Cartransmission;
use App\Models\Carwheelsystem;
use App\Models\Catgories;
use App\Models\city;
use App\Models\realstateperiod;
use App\Models\realstatetype;
use App\Models\Carenginetype;
use Illuminate\Database\Seeder;

class DynamicDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Catgories::create([
            'name_ar'      =>        'سيارات',
            'name_en'      =>        'Cars',
            'img'          =>        'Cars.png',
            'editable'     =>        0,
        ]);
        Catgories::create([
            'name_ar'      =>        'عقارات',
            'name_en'      =>        'Real State',
            'img'          =>        'realstate.png',
            'editable'     =>        0,
        ]);


        Catgories::create([
            'name_ar'      =>        'سيارات للبع',
            'name_en'      =>        'Car For sale',
            'parent_id'    =>        1,
            'editable'     =>        1,
        ]);
        Catgories::create([
            'name_ar'      =>        'سيارات للايجار',
            'name_en'      =>        'Car for Rent',
            'parent_id'    =>        1,
            'editable'     =>        1,
        ]);

        Catgories::create([
            'name_ar'      =>        'عقارات للبع',
            'name_en'      =>        'realstate for sale',
            'parent_id'    =>        2,
            'editable'     =>        1,
        ]);
        Catgories::create([
            'name_ar'      =>        'عقارات للايجار',
            'name_en'      =>        'realstate for rent',
            'parent_id'    =>        2,
            'editable'     =>        1,
        ]);
        Catgories::create([
            'name_ar'      =>        'قسم رئيسي 1',
            'name_en'      =>        'main cat 1',
            'img'          =>        'Cars.png',
            'editable'     =>        0,
        ]);
        Catgories::create([
            'name_ar'      =>        'قسم رئيسي 2',
            'name_en'      =>        'main cat 2',
            'img'          =>        'realstate.png',
            'editable'     =>        0,
        ]);
        city::create([
            'name_ar'      =>        'القاهره',
            'name_en'      =>        'Cairo',

        ]);
        area::create([
            'name_ar'      =>        'القاهره الجديده',
            'name_en'      =>        'new Cairo',
            'city_id'      =>        1,

        ]);
        area::create([
            'name_ar'      =>        'القاهره الجديده',
            'name_en'      =>        'new Cairo',
            'city_id'      =>        1,

        ]);
        carBrands::create([
            'name_ar'      =>        'مرسيدس',
            'name_en'      =>        'Marcedess',

        ]);
        carModels::create([
            'name_ar'      =>        'مرسيدس اصدار1',
            'name_en'      =>        'Marcedess v1',
            'brand_id'     =>       1,

        ]);
        carModels::create([
            'name_ar'      =>        'مرسيدس اصدار2',
            'name_en'      =>        'Marcedess v2',
            'brand_id'     =>       1,

        ]);

        Carcolors::create([
            'name_ar'      =>        'احمر',
            'name_en'      =>        'red',

        ]);
        Carcolors::create([
            'name_ar'      =>        'ابيض',
            'name_en'      =>        'white',

        ]);
        Carfules::create([
            'name_ar'      =>        'جاز',
            'name_en'      =>        'gas',

        ]);
        Carfules::create([
            'name_ar'      =>        'بنزين',
            'name_en'      =>        'oil',

        ]);
        Carstatus::create([
            'name_ar'      =>        'جديد',
            'name_en'      =>        'New Cars',
        ]);
        Carstatus::create([
            'name_ar'      =>        'مستعمل',
            'name_en'      =>        'Used cars',
        ]);

        Carshapes::create([
            'name_ar'      =>        'سيدان',
            'name_en'      =>        'Syedan',
        ]);
        Carshapes::create([
            'name_ar'      =>        'هاتشباك',
            'name_en'      =>        'hashtbak',
        ]);
        Cartransmission::create([
            'name_ar'      =>        'مانيوال',
            'name_en'      =>        'Manual',
        ]);
        Cartransmission::create([
            'name_ar'      =>        'اتوماتيك',
            'name_en'      =>        'Automatic',
        ]);

        Carwheelsystem::create([
            'name_ar'      =>        'ثنائي امامي',
            'name_en'      =>        'Front two',
        ]);
        Carwheelsystem::create([
            'name_ar'      =>        'ثنائي خلفي',
            'name_en'      =>        'Rear binary',
        ]);

        Carenginetype::create([
            'name_ar'      =>        '4 سلندر',
            'name_en'      =>        '4 seleynder',
        ]);
        Carenginetype::create([
            'name_ar'      =>        '6 سلندر',
            'name_en'      =>        '6 seleynder',
        ]);

        Cardoors::create([
            'numbers'       =>       2,
        ]);
        Cardoors::create([
            'numbers'       =>       3,
        ]);
        Cardoors::create([
            'numbers'       =>       4,
        ]);


        Carseats::create([
            'numbers'       =>       2,
        ]);
        Carseats::create([
            'numbers'       =>       4,
        ]);
        Carseats::create([
            'numbers'       =>       5,
        ]);

        realstatetype::create([
            'name_ar'      =>        'شقه',
            'name_en'      =>        'Department',
        ]);
        realstatetype::create([
            'name_ar'      =>        'فيلا',
            'name_en'      =>        'Villa',
        ]);

        realstateperiod::create([
            'name_ar'      =>        'طويل الامد',
            'name_en'      =>        'long-term',
        ]);
        realstateperiod::create([
            'name_ar'      =>        'قصير الامد',
            'name_en'      =>        'Short-lived',
        ]);

    }
}
