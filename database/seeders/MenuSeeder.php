<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [

            [
                'name' => 'Espresso Classico',
                'category' => 'Espresso',
                'origin' => 'Toraja, Sulawesi',
                'price' => '22000',
                'description' => 'Shot tunggal biji Arabica Toraja, roasted medium-dark dengan crema tebal berwarna hazel. Bold, syrupy, dan penuh karakter.',
                'full_description' => 'Espresso Classico kami adalah fondasi dari semua minuman berbasis kopi di KŌHI. Dibuat dari biji Arabica pilihan asal Toraja, Sulawesi Selatan.',
                'image' => null,
                'temperature' => 'hot',
                'is_popular' => true,
                'is_new' => false,
            ],

            [
                'name' => 'Doppio Ristretto',
                'category' => 'Espresso',
                'origin' => 'Aceh Gayo, Sumatra',
                'price' => '28000',
                'description' => 'Double shot ristretto ultra-concentrated dari biji Gayo.',
                'full_description' => 'Doppio Ristretto adalah dua shot espresso yang diekstrak dengan volume air yang lebih sedikit dari biasanya.',
                'image' => null,
                'temperature' => 'hot',
                'is_popular' => false,
                'is_new' => false,
            ],

            [
                'name' => 'Americano Lungo',
                'category' => 'Espresso',
                'origin' => 'Flores, NTT',
                'price' => '28000',
                'description' => 'Espresso panjang dengan tambahan hot water.',
                'full_description' => 'Americano Lungo dibuat dengan menyeduh espresso langsung ke dalam air panas.',
                'image' => null,
                'temperature' => 'both',
                'is_popular' => false,
                'is_new' => false,
            ],

            [
                'name' => 'Matcha Latte',
                'category' => 'Matcha',
                'origin' => 'Uji, Kyoto, Jepang',
                'price' => '38000',
                'description' => 'Matcha ceremonial grade Uji dilarutkan sempurna.',
                'full_description' => 'Matcha latte kami menggunakan bubuk matcha ceremonial grade dari Uji Kyoto.',
                'image' => null,
                'temperature' => 'both',
                'is_popular' => true,
                'is_new' => false,
            ],

            [
                'name' => 'Dirty Matcha',
                'category' => 'Latte',
                'origin' => 'Uji + Toraja',
                'price' => '44000',
                'description' => 'Matcha ceremonial bertemu espresso shot panas.',
                'full_description' => 'Dirty Matcha adalah perpaduan paling kontroversial di menu kami.',
                'image' => null,
                'temperature' => 'both',
                'is_popular' => true,
                'is_new' => false,
            ],

            [
                'name' => 'Classic Cold Brew',
                'category' => 'Cold Brew',
                'origin' => 'Flores, NTT',
                'price' => '42000',
                'description' => '18 jam cold extraction biji Flores.',
                'full_description' => 'Cold Brew kami menggunakan metode immersion selama 18 jam.',
                'image' => null,
                'temperature' => 'cold',
                'is_popular' => true,
                'is_new' => false,
            ],

            [
                'name' => 'Cappuccino',
                'category' => 'Latte',
                'origin' => 'Toraja, Sulawesi',
                'price' => '32000',
                'description' => 'Espresso Toraja dengan microfoam susu segar.',
                'full_description' => 'Cappuccino klasik kami mengikuti rasio tradisional Italia.',
                'image' => null,
                'temperature' => 'hot',
                'is_popular' => true,
                'is_new' => false,
            ],

            [
                'name' => 'Lavender Latte',
                'category' => 'Latte',
                'origin' => 'Toraja, Sulawesi',
                'price' => '40000',
                'description' => 'Floral dan elegan.',
                'full_description' => 'Lavender Latte kami menggunakan lavender culinary grade.',
                'image' => null,
                'temperature' => 'both',
                'is_popular' => false,
                'is_new' => false,
            ],

            [
                'name' => 'Pour Over Aceh Gayo',
                'category' => 'Single Origin',
                'origin' => 'Aceh Gayo, Sumatra',
                'price' => '55000',
                'description' => 'Manual brewing V60 dengan biji Gayo grade specialty.',
                'full_description' => 'Pour Over adalah cara terbaik untuk mengapresiasi biji kopi single origin.',
                'image' => null,
                'temperature' => 'hot',
                'is_popular' => false,
                'is_new' => false,
            ],

            [
                'name' => 'Chocolate Noir',
                'category' => 'Non-Coffee',
                'origin' => 'Sulawesi Cacao',
                'price' => '40000',
                'description' => 'Dark chocolate 70% Sulawesi.',
                'full_description' => 'Chocolate Noir kami bukan coklat sachet biasa.',
                'image' => null,
                'temperature' => 'both',
                'is_popular' => false,
                'is_new' => false,
            ],

        ];

        foreach ($menus as $menu) {

            Menu::create($menu);

        }

    }

}

