<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Models\Food;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    const STATUS_SUCCESS = 200;
    const STATUS_NOT_FOUND = 404;
    const STATUS_NOT_IMPLEMENTED = 501;

    public function index()
    {
        $foods = Food::all();

        if (isset($foods) && !empty($foods) && $foods->count() > 0) {
            return response()->json($foods, SELF::STATUS_SUCCESS);
        }
        return response()->json(['message' => 'No data found'], self::STATUS_NOT_FOUND);
    }

    public function show(Request $request)
    {
        if ($request->input('food_id')) {
            $food = Food::find($request->input('food_id'));

            if (isset($food) && !empty($food) && $food->count() > 0) {
                return response()->json($food, SELF::STATUS_SUCCESS);
            }
            return response()->json(['message' => 'No data found'], self::STATUS_NOT_FOUND);
        } else {
            $res = [
                'status' => 'error',
                'message' => 'food id field is required to locate resource',
            ];
            return response()->json($res, SELF::STATUS_NOT_IMPLEMENTED);
        }
    }

    public function store(Request $request)
    {
        if ($request->input('food_name')) {
            $food = ['name' => $request->input('food_name')];

            if ($request->input('description')) $food['description'] = $request->input('description');
            if ($request->input('expiry_date')) $food['expiry_date'] = $request->input('expiry_date');
            if ($request->input('quantity')) $food['quantity'] = $request->input('quantity');

            $food = Food::create($food);

            //attach food with donor if donor id is present in request and it exists
            if ($request->input('donor_id')) {
                $donor = Donor::find($request->input('donor_id'));

                if (isset($donor) && !empty($donor) && $donor->count() > 0) {
                    $food->donors()->attach($donor);
                }
            }

            $res = [
                'status' => 'implemented',
                'message' => 'resource created successfully',
            ];
            return response()->json($res, SELF::STATUS_SUCCESS);
        } else {
            $res = [
                'status' => 'not implemented',
                'message' => 'name field is required to create resource',
            ];
            return response()->json($res, SELF::STATUS_NOT_IMPLEMENTED);
        }
    }

    public function update(Request $request)
    {
        if ($request->input('food_id')) {
            $food = Food::find($request->input('food_id'));
            if (isset($food->name) && !empty($food->name)) {

                $updatedFood = [];
                if ($request->input('food_name'))  $updatedFood['name'] = $request->input('food_name');
                if ($request->input('description')) $updatedFood['description'] = $request->input('description');
                if ($request->input('expiry_date')) $updatedFood['expiry_date'] = $request->input('expiry_date');
                if ($request->input('quantity')) $updatedFood['quantity'] = $request->input('quantity');

                if ($updatedFood) $food->update($updatedFood);

                //attach food with donor if donor id is present in request and it exists
                if ($request->input('donor_id')) {
                    $donor = Donor::find($request->input('donor_id'));

                    if (isset($donor) && !empty($donor) && $donor->count() > 0) {
                        $food->donors()->attach($donor);
                    }
                }

                $res = [
                    'status' => 'updated',
                    'message' => 'resource updated successfully',
                ];
                return response()->json($res, SELF::STATUS_SUCCESS);
            } else {
                return response()->json(['message' => 'resource not found'], SELF::STATUS_NOT_FOUND);
            }
        } else {
            $res = [
                'status' => 'not updated',
                'message' => 'food id field is required to update resource',
            ];
            return response()->json($res, SELF::STATUS_NOT_IMPLEMENTED);
        }
    }
    public function destroy(Request $request)
    {
        if ($request->input('food_id')) {

            try {
                Food::where('id', $request->input('food_id'))->firstOrFail()->delete();

                return response()->json(['message' => 'Record deleted successfully'], SELF::STATUS_SUCCESS);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'Record not found.'], SELF::STATUS_NOT_FOUND);
            }
        } else {
            $res = [
                'status' => 'not implemented',
                'message' => 'food id field is required to delete resource',
            ];
            return response()->json($res, SELF::STATUS_NOT_IMPLEMENTED);
        }
    }
}
