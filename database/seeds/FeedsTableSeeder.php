<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeedsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $feeds = [
            ['15min', 'https://www.15min.lt/rss/lietuva', 'Lietuva'],
            ['15min', 'https://www.15min.lt/rss/orai', 'Orai'],
            ['15min', 'https://www.15min.lt/rss/nusikaltimaiirnelaimes', 'Kriminalai'],
            ['15min', 'https://www.15min.lt/rss/pasaulis', 'Užsienis'],
            ['15min', 'https://www.15min.lt/rss/sveikata', 'Sveikata'],
            ['delfi', 'https://www.delfi.lt/rss/feeds/lithuania.xml', 'Lietuva'],
            ['delfi', 'https://www.delfi.lt/rss/feeds/crime.xml', 'Kriminalai'],
            ['delfi', 'https://www.delfi.lt/rss/feeds/world.xml', 'Užsienis'],

        ];

        foreach ($feeds as $feed) {
            DB::table('feeds')->insert([
                'name'     => $feed[0],
                'url'      => $feed[1],
                'category' => $feed[2],
            ]);
        }
    }
}
