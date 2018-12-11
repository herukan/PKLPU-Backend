<?php

use Illuminate\Database\Seeder;

use App\Siswa;
use App\Pemeliharaan;
use App\Peminjaman;
use App\Kendaraan;
use App\Peminjam;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $modelName = array(
            'DR3131KS',
            'DR9129AM',
            'DR0121AC',
            'DR1023BB',
            'DR9819MN',
            'DR1209DM'
        );
        $products = [
            'Tersedia',
        ];

        $jumlahl = [
            '1',
            '2',
            '3'
        ];

        $plat = [
            'DR3131KS',
            'DR9129AM',
            'DR0121AC',
            'DR1023BB',
            'DR9819MN',
            'DR1209DM'
        ];

        $jenis = [
            'Mobil',
            'Motor',
            'Truk',
            'Eskavator',
            'Stomp',
        ];

        $tanggal = [
            '04/11/2018',
            '15/02/2019',
            '23/03/2018',
            '31/04/2018',
            '29/05/2018',
        ];

        $jenisbb = [
            'Premium',
            'Solar',
            'Pertalite',
            'Gas',
            'Pertamax',
        ];

        $tipeservice = [
            'Ganti Oli',
            'Kaburator',
            'Ganti Ban',
            'Radiator',
            'kaca',
        ];

        $sukucadang = [
            'Oli',
            'Kaburator',
            'Ban',
            'Radiator',
            'Rem',
        ];
        

        // Create 50 product records
        for ($i = 0; $i < 50; $i++) {
            Siswa::create([
                'nama' => $faker->name,
                'alamat' => $faker->address
            ]);

            Pemeliharaan::create([
                'plat' => $plat[rand(0, count($plat) - 1)],
                'jenis' => $jenis[rand(0, count($jenis) - 1)],
                'odometer' => $faker->areaCode,
                'keterangan' => $faker->address,
                'jenis_bb' => $jenisbb[rand(0, count($jenisbb) - 1)],
                'harga_bb' => $faker->areaCode,
                'jumlah_bb' => $jumlahl[rand(0, count($jumlahl) - 1)],
                'tipe_service' => $tipeservice[rand(0, count($tipeservice) - 1)],
                'harga_service' => $faker->areaCode,
                'tgl_mulai' => $tanggal[rand(0, count($tanggal) - 1)],
                'tgl_selesai' => $tanggal[rand(0, count($tanggal) - 1)],
                'suku_cadang' => $sukucadang[rand(0, count($sukucadang) - 1)],
                'harga_suku' => $faker->areaCode,
            ]);

        
            Peminjaman::create([
                'nama' => $faker->name,
                'instansi' => $faker->name,
                'alamat' => $faker->address,
                'perihal' => $faker->address,
                'tgl_mulai' => $tanggal[rand(0, count($tanggal) - 1)],
                'tgl_kembali' => $tanggal[rand(0, count($tanggal) - 1)],
                'jenis' => $jenis[rand(0, count($jenis) - 1)],
                'plat' => $plat[rand(0, count($plat) - 1)],
                'harga' => $faker->areaCode,
                'status' => $products[rand(0, count($products) - 1)],
            ]);

            Kendaraan::create([
                'plat' => $plat[rand(0, count($plat) - 1)],
                'jenis' => $jenis[rand(0, count($jenis) - 1)],
                'status' => $products[rand(0, count($products) - 1)]
            ]);

            Peminjam::create([
                'nama' => $faker->name,
                'instansi' => $faker->name,
                'alamat' => $faker->address
            ]);
        }
    }
}
