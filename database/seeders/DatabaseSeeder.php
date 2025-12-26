<?php

namespace Database\Seeders;

use App\Models\Domestic\DomesticAirline;
use App\Models\Domestic\DomesticSector;
use App\Models\Domestic\Plasma;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Plasma::create([
            'endpoint' => 'http://usbooking.org/us/UnitedSolutions?wsdl',
            'test_endpoint' => 'http://dev.usbooking.org/us/UnitedSolutions?wsdl',
            'username' => 'FGYANI',
            'test_username' => 'PARADI',
            'password' => '@@FGY@AN185',
            'test_password' => 'PASSWORD',
            'agencyid' => 'PLZ185',
            'test_agencyid' => 'PLZ146',
            'environment' => 1,
            'company' => 'Flightsgyani'
        ]);

        $airlines = [
            ['name' => 'Buddha Air', 'code' => 'U4', 'image' => 'U4.jpg', 'text' => null, 'status' => 1, 'order' => 1, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'Saurya Airlines', 'code' => 'S1', 'image' => 'S1.jpg', 'text' => null, 'status' => 1, 'order' => 2, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'Simrik Airlines', 'code' => 'RMK', 'image' => 'RMK.jpg', 'text' => null, 'status' => 1, 'order' => 3, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'Yeti Airlines', 'code' => 'YT', 'image' => 'YT.jpg', 'text' => null, 'status' => 1, 'order' => 4, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'Goma Airlines', 'code' => 'GA', 'image' => null, 'text' => null, 'status' => 1, 'order' => 5, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'Shree Airlines', 'code' => 'SHA', 'image' => 'SHA.jpg', 'text' => null, 'status' => 1, 'order' => 6, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'Sita Air', 'code' => 'ST', 'image' => null, 'text' => null, 'status' => 1, 'order' => 7, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')]
        ];

        DomesticAirline::insert($airlines);

        $sectors = [
            ['name' => 'BAJURA', 'code' => 'BJU', 'image' => null, 'text' => null, 'status' => 1, 'order' => 1, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'BHADRAPUR', 'code' => 'BDP', 'image' => null, 'text' => null, 'status' => 1, 'order' => 2, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'BHAIRAHAWA', 'code' => 'BWA', 'image' => null, 'text' => null, 'status' => 1, 'order' => 3, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'BHARATPUR', 'code' => 'BHR', 'image' => null, 'text' => null, 'status' => 1, 'order' => 4, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'BIRATNAGAR', 'code' => 'BIR', 'image' => null, 'text' => null, 'status' => 1, 'order' => 5, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'DANG', 'code' => 'DNG', 'image' => null, 'text' => null, 'status' => 1, 'order' => 6, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'DHANGADHI', 'code' => 'DHI', 'image' => null, 'text' => null, 'status' => 1, 'order' => 7, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'DOLPA', 'code' => 'DOP', 'image' => null, 'text' => null, 'status' => 1, 'order' => 8, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'JANAKPUR', 'code' => 'JKR', 'image' => null, 'text' => null, 'status' => 1, 'order' => 9, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'JOMSOM', 'code' => 'JMO', 'image' => null, 'text' => null, 'status' => 1, 'order' => 10, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'JUMLA', 'code' => 'JUM', 'image' => null, 'text' => null, 'status' => 1, 'order' => 11, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'KATHMANDU', 'code' => 'KTM', 'image' => null, 'text' => null, 'status' => 1, 'order' => 12, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'LUKLA', 'code' => 'LUA', 'image' => null, 'text' => null, 'status' => 1, 'order' => 13, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'MOUNTAIN', 'code' => 'MTN', 'image' => null, 'text' => null, 'status' => 1, 'order' => 14, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'NEPALGUNJ', 'code' => 'KEP', 'image' => null, 'text' => null, 'status' => 1, 'order' => 15, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'POKHARA', 'code' => 'PKR', 'image' => null, 'text' => null, 'status' => 1, 'order' => 16, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'RAJBIRAJ', 'code' => 'RJB', 'image' => null, 'text' => null, 'status' => 1, 'order' => 17, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'RAMECHHAP', 'code' => 'RHP', 'image' => null, 'text' => null, 'status' => 1, 'order' => 18, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'RARA', 'code' => 'TLH', 'image' => null, 'text' => null, 'status' => 1, 'order' => 19, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'SANFEBAGAR', 'code' => 'FEB', 'image' => null, 'text' => null, 'status' => 1, 'order' => 20, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'SIMARA', 'code' => 'SIF', 'image' => null, 'text' => null, 'status' => 1, 'order' => 21, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'SIMIKOT', 'code' => 'IMK', 'image' => null, 'text' => null, 'status' => 1, 'order' => 22, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'SURKHET', 'code' => 'SKH', 'image' => null, 'text' => null, 'status' => 1, 'order' => 23, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'TUMLINGTAR', 'code' => 'TMI', 'image' => null, 'text' => null, 'status' => 1, 'order' => 24, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')],
            ['name' => 'VARANASI', 'code' => 'VNS', 'image' => null, 'text' => null, 'status' => 1, 'order' => 25, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')]
        ];

        DomesticSector::insert($sectors);
    }
}
