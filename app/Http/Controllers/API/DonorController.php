<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Models\Food;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    const STATUS_SUCCESS = 200;
    const STATUS_NOT_FOUND = 404;
    const STATUS_NOT_IMPLEMENTED = 501;

    public function index()
    {
        $donors = Donor::all();

        if (isset($donors) && !empty($donors && $donors->count() > 0)) {
            return response()->json($donors, SELF::STATUS_SUCCESS);
        }
        return response()->json(['message' => 'No data found'], self::STATUS_NOT_FOUND);
    }

    public function store(Request $request)
    {
        if ($request->input('donor_name')) {
            $donor['name']  = $request->input('donor_name');

            if ($request->input('contact_info')) $donor['contact_info'] = $request->input('contact_info');

            $donor = Donor::create($donor);

            //attach food with donor if food id is present in request and it exists
            if ($request->input('food_id')) {
                $food = Food::find($request->input('food_id'));

                if (isset($food) && !empty($food) && $food->count() > 0) {
                    $donor->foods()->attach($food);
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
        if ($request->input('donor_id')) {
            $donor = Donor::find($request->input('donor_id'));
            if (isset($donor->name) && !empty($donor->name)) {

                $updatedDonor = [];
                if ($request->input('donor_name'))  $updatedDonor['name'] = $request->input('donor_name');
                if ($request->input('contact_info')) $updatedDonor['contact_info'] = $request->input('contact_info');

                if ($updatedDonor) $donor->update($updatedDonor);

                //attach food with donor if food id is present in request and it exists
                if ($request->input('food_id')) {
                    $food = Food::find($request->input('food_id'));

                    if (isset($food) && !empty($food) && $food->count() > 0) {
                        $donor->foods()->attach($food);
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
                'message' => 'donor id field is required to update resource',
            ];
            return response()->json($res, SELF::STATUS_NOT_IMPLEMENTED);
        }
    }
    public function destroy(Request $request)
    {
        if ($request->input('donor_id')) {

            try {
                Donor::where('id', $request->input('donor_id'))->firstOrFail()->delete();

                return response()->json(['message' => 'Record deleted successfully'], SELF::STATUS_SUCCESS);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'Record not found.'], SELF::STATUS_NOT_FOUND);
            }
        } else {
            $res = [
                'status' => 'not implemented',
                'message' => 'donor id field is required to delete resource',
            ];
            return response()->json($res, SELF::STATUS_NOT_IMPLEMENTED);
        }
    }

    public function getDonatedItems(Request $request){
        if ($request->input('donor_id')) {
            $donor = Donor::find($request->input('donor_id'));

            if (isset($donor) && !empty($donor) && $donor->count() > 0) {
                $foods = $donor->foods; // retieve all foods donated by donor
                if (isset($foods) && !empty($foods) && $foods->count() > 0) {
                    return response()->json($foods, SELF::STATUS_SUCCESS);
                }
                return response()->json(['message' => 'No food donated by this donor'], self::STATUS_NOT_FOUND);
            }
            return response()->json(['message' => 'No donor found'], self::STATUS_NOT_FOUND);
        } else {
            $res = [
                'status' => 'error',
                'message' => 'donor id field is required to locate resource',
            ];
            return response()->json($res, SELF::STATUS_NOT_IMPLEMENTED);
        }
    }
}
