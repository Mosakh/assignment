<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Location;
use App\Models\Shop;
use App\Models\Vaccine;
use App\Models\Visitor;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class AssignmentDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        try {

            $this->location();
            $this->vaccine();
            $this->shop();
            $this->card();
            $visitor = $this->vistor();

            foreach($visitor as $value )
            {
                Visitor::insert($value);
            }

        } catch (Exception $e) {
            dd($e->getMessage());
            Log::error($e->getMessage());
        }
    }

    private function location(): array
    {
        $data = [
            [
                'name' => 'Phnom Penh',
                'code' => 'PHNOM_PENH'
            ],
            [
                'name' => 'Kandal',
                'code' => 'KANDAL'
            ],
            [
                'name' => 'Pursat',
                'code' => 'PURSAT'
            ],
        ];
        Location::insert($data);

        return $data;
    }

    private function vaccine(): array
    {
        $data = [
            [
                'name' => 'vaccince_001',
                'doses' => 1
            ],
            [
                'name' => 'vaccince_002',
                'doses' => 2
            ],
            [
                'name' => 'vaccince_003',
                'doses' => 3
            ],
            [
                'name' => 'vaccince_004',
                'doses' => 4
            ], [
                'name' => 'vaccince_005',
                'doses' => 5
            ],
        ];
        Vaccine::insert($data);
        return $data;
    }


    private function shop(): void
    {
        try {
            $data = [];
            for ($i = 1; $i <= 9; $i++) {
                $data[] = [
                    'shop_name' => 'shop_0' . $i,
                    'code' => random_int(1000, 99999),
                    'location' => $this->limiteLocation($i),
                ];
            }
            Shop::insert($data);
        } catch (Exception $e) {
          throw new Exception($e->getMessage());
        }
    }

    private function limiteLocation(int $id, int $num = 3): int
    {

        if ($id > 0 && $id <= $num) {
            return $id;
        }
        if ($id > $num) {
            $new = $id - $num;
            if ($new < $num) {
                return $new;
            } else {
                return $this->limiteLocation($new);
            }
        }
    }

    private function card(): void
    {
        try {

            $data = [
                [
                    'code' => "MOH_" . random_int(1000, 9999),
                    'card_name' => "Ministry of Health",
                    'type' => "MOH",
                ],
                [
                    'code' => "MOD_" . random_int(1000, 9999),
                    'card_name' => "Ministry of National Defense",
                    'type' => "MOD",
                ],
            ];
            Card::insert($data);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function vistor(): array
    {
        try {
            $data = [];
            $shop = new Shop();
            foreach ($this->location() as $key => $value) {
                if ($value['code'] === 'PHNOM_PENH') {

                    $phnomPenh = $shop->where('location', 1)->pluck('code')->toArray();
                    $data[$key] = $this->createVisitor(100, $value['code'], $phnomPenh, 70, 30, 5);
                }
                if ($value['code'] === 'KANDAL') {
                    $kandal = $shop->where('location', 2)->pluck('code')->toArray();
                    $data[$key] = $this->createVisitor(200, $value['code'], $kandal, 199, 1, 1);
                }
                if ($value['code'] === 'PURSAT') {
                    $pursat = $shop->where('location', 3)->pluck('code')->toArray();
                    $data[$key] = $this->createVisitor(300, $value['code'], $pursat, 200, 100, 3);
                }
            }

            return $data;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function createVisitor(int $num, string $location, array $shop, int $moh, int $mod, int $doses)
    {
        try {
            $gender = ['Male', 'Female'];
            $data = [];
            for ($i = 1; $i <= $num; $i++) {

                if ($i <= $moh) {
                    $data[$i] = [
                        'name' => 'vistor_' . random_int(10000, 99999),
                        'card_type' => "MOH"
                    ];
                } else {
                    $data[$i] = [
                        'name' => 'vistor_' . random_int(10000, 99999),
                        'card_type' => "MOD"
                    ];
                }
                $data[$i]['shop_code'] =  $shop[array_rand($shop)];
                $data[$i]['vaccine_doses'] = $doses;
                $data[$i]['gender'] = $gender[array_rand($gender)];
                $data[$i]['age'] = random_int(14, 48);
            }
            return $data;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
