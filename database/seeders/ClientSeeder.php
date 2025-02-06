<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'AHMED TEA','image'=>'AHMED_TEA.jpg'],
            ['name' => 'ALHAMRA','image'=>'ALHAMRA.jpg'],
            ['name' => 'FALCON PACK','image'=>'FALCON_PACK.jpg'],
            ['name' => 'MARJAN','image'=>'MARJAN.jpg'],
            ['name' => 'MINISTTRY OF PRESIDENTIAL AFFAIRS','image'=>'MINISTTRY_OF_PRESIDENTIAL_AFFAIRS.jpg'],
            ['name' => 'RAKEZ','image'=>'rakez.jpg'],
            ['name' => 'SOBHA','image'=>'SOBHA.jpg'],
            ['name' => 'SUNREEF YACHTS','image'=>'SUNREEF_YACHTS.jpg'],
            ['name' => 'U PAK','image'=>'U-PAK.jpg'],
            ['name' => 'UTICO','image'=>'UTICO.jpg'],
            ['name' => 'YAMUNA DENSONS','image'=>'YAMUNA_DENSONS.jpg'],
            ['name' => 'Ministry of Interior', 'image' =>'Ministry_of_Interior.jpg'],
            ['name' => 'Ministry of Health' , 'image' => 'Ministry_of_Health.jpg'],
            ['name' => 'Ministry of Public Works' , 'image' => 'Ministry_of_Public_Works.jpg'],
            ['name' => 'MINISTTRY OF INFRASTRUCURE' , 'image' => 'MINISTTRY_OF_INFRASTRUCURE.jpg'],
            ['name' => 'BANYAN TREE' , 'image' => 'BANYAN_TREE.jpg' ],
            ['name' => 'Crown Prince Court' , 'image' => 'CROWN_PRINCE_COURT.jpg' ],
            ['name' => 'Streit Group' , 'image' => 'Streit_Group.jpg' ],
            ['name' => 'RAK Economic Zone' , 'image' => 'rakez.jpg' ],
            ['name' => 'AG Aluminum' , 'image' => 'AG_Aluminum.jpg' ],
            ['name' => 'FINE' , 'image' => 'FINE.jpg' ],
            ['name' => 'iPack' , 'image' => 'iPack.jpg' ],
            ['name' => 'Fence International' , 'image' => 'Fence_International.jpg' ],
            ['name' => 'Etihad Railway' , 'image' => 'Etihad_Railway.jpg' ],
            ['name' => 'Ashok leyland' , 'image' => 'Ashok_leyland.jpg' ],
            ['name' => 'Hira' , 'image' => 'Hira.jpg' ],
            ['name' => 'Ginox' , 'image' => 'Ginox.jpg' ],
            ['name' => 'Kalister' , 'image' => 'Kalister.jpg' ],
            ['name' => 'Mabani' , 'image' => 'Mabani.jpg' ],
            ['name' => 'Crcc' , 'image' => 'Crcc.jpg' ],
            ['name' => 'Al Jazeera Port' , 'image' => 'Al_Jazeera_Port.jpg' ],
            ['name' => 'Universal carton' , 'image' => 'Universal_carton.jpg' ],
            ['name' => 'fine hygienic' , 'image' => 'fine_hygienic.jpg' ],
            ['name' => 'IAG' , 'image' => 'IAG.jpg' ],
            ['name' => 'Lafarge cement' , 'image' => 'Lafarge_cement.jpg' ],
            ['name' => 'TenCate' , 'image' => 'TenCate.jpg' ],
            ['name' => 'Al Ain Flour Mill' , 'image' => 'Al_Ain_Flour_Mill.jpg' ],
            ['name' => 'Dabur' , 'image' => 'Dabur.jpg' ],
            ['name' => 'NPC' , 'image' => 'NPC.jpg' ],
            ['name' => 'RAK PORTS' , 'image' => 'RAK_PORTS.jpg' ],
            ['name' => 'RAS AL KHAIMA MANICIPALITY' , 'image' => 'RAS_AL_KHAIMA_MANICIPALITY.jpg' ],
            ['name' => 'CROWN PRINCE COURT' , 'image' => 'CROWN_PRINCE_COURT.jpg' ],
            ['name' => 'Sharja Muncipality' , 'image' => 'Sharja_Muncipality.jpg' ],
            ['name' => 'Jotun' , 'image' => 'Jotun.jpg' ],
            ['name' => 'Rixos' , 'image' => 'Rixos.jpg' ],
            ['name' => 'MacDonalds' , 'image' => 'MacDonalds.jpg' ],
            ['name' => 'TAG' , 'image' => 'TAG.jpg' ],
        ];
        foreach ($data as $key => $value) {
            Client::create([
                'name' => $value['name'],
                'image' => $value['image']
            ]);
        }
    }
}
