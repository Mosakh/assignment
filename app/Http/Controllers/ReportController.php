<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $shop =  Shop::with(['locations', 'visitors'])->get();
            $data = [];
            $visitor = [];
            foreach ($shop as $value) {

                foreach ($value->visitors->toArray() as $values) {
                    $values['location_name'] = $value->locations['name'];
                    $visitor[$value->locations['id']][] = $values;
                }
            }
            foreach ($visitor as $key => $value) {
                $visite = collect($value);
                $data[$key] = [
                    'province' => array_keys($visite->groupBy('location_name')->toArray())[0],
                    'doses' => array_keys($visite->groupBy('vaccine_doses')->toArray())[0],
                    'visitor' => $visite->count(),
                    'MOH' => $visite->where('card_type', 'MOH')->count(),
                    'MOD' => $visite->where('card_type', 'MOD')->count(),
                ];
            }
           return response()->json($data);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
