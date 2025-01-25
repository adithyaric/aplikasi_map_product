<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Provinsi
        $provinsi = Location::create(['name' => 'Provinsi Jawa Timur', 'type' => 'provinsi']);

        // Kabupaten
        $kabupatenMadiun = Location::create(['name' => 'Kabupaten Madiun', 'type' => 'kabupaten', 'parent_id' => $provinsi->id]);
        $kabupatenPacitan = Location::create(['name' => 'Kabupaten Pacitan', 'type' => 'kabupaten', 'parent_id' => $provinsi->id]);

        // Kecamatan
        $kecamatanDopo = Location::create(['name' => 'Kecamatan Dopo', 'type' => 'kecamatan', 'parent_id' => $kabupatenMadiun->id]);
        $kecamatanGeger = Location::create(['name' => 'Kecamatan Geger', 'type' => 'kecamatan', 'parent_id' => $kabupatenMadiun->id]);

        $kecamatanArjosari = Location::create(['name' => 'Kecamatan Arjosari', 'type' => 'kecamatan', 'parent_id' => $kabupatenPacitan->id]);

        // Desa
        Location::create(['name' => 'Desa Sidoharjo', 'type' => 'desa', 'parent_id' => $kecamatanDopo->id]);
        Location::create(['name' => 'Desa Munggut', 'type' => 'desa', 'parent_id' => $kecamatanGeger->id]);

        Location::create(['name' => 'Desa Ngumbul', 'type' => 'desa', 'parent_id' => $kecamatanArjosari->id]);
    }
}
