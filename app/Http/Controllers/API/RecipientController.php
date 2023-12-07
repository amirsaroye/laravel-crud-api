<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Recipient;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class RecipientController extends Controller
{
    const STATUS_SUCCESS = 200;
    const STATUS_NOT_FOUND = 404;
    const STATUS_NOT_IMPLEMENTED = 501;

    public function index()
    {
        $recipients = Recipient::all();

        if (isset($recipients) && !empty($recipients) && $recipients->count() > 0) {
            return response()->json($recipients, SELF::STATUS_SUCCESS);
        }
        return response()->json(['message' => 'No data found'], self::STATUS_NOT_FOUND);
    }

    public function store(Request $request)
    {
        if ($request->input('recipient_name')) {
            $recipient ['name']  = $request->input('recipient_name');

            if ($request->input('contact_info')) $recipient['contact_info'] = $request->input('contact_info');

            $recipient = Recipient::create($recipient);

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
        if ($request->input('recipient_id')) {
            $recipient = Recipient::find($request->input('recipient_id'));
            if (isset($recipient->name) && !empty($recipient->name)) {
                
                $updatedrecipient = [];
                if ($request->input('recipient_name'))  $updatedrecipient['name'] = $request->input('recipient_name');
                if ($request->input('contact_info')) $updatedrecipient['contact_info'] = $request->input('contact_info');

                if($updatedrecipient) $recipient->update($updatedrecipient);

                $res = [
                    'status' => 'updated',
                    'message' => 'resource updated successfully',
                ];
                return response()->json($res, SELF::STATUS_SUCCESS);
            } else {
                return response()->json(['message' => 'resource not found'],SELF::STATUS_NOT_FOUND);
            }
        } else {
            $res = [
                'status' => 'not updated',
                'message' => 'recipient id field is required to update resource',
            ];
            return response()->json($res, SELF::STATUS_NOT_IMPLEMENTED);
        }
    }
    public function destroy(Request $request)
    {
        if ($request->input('recipient_id')) {

            try {
                Recipient::where('id', $request->input('recipient_id'))->firstOrFail()->delete();

                return response()->json(['message' => 'Record deleted successfully'], SELF::STATUS_SUCCESS);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'Record not found.'], SELF::STATUS_NOT_FOUND);
            }
        } else {
            $res = [
                'status' => 'not implemented',
                'message' => 'recipient id field is required to delete resource',
            ];
            return response()->json($res, SELF::STATUS_NOT_IMPLEMENTED);
        }
    }
}
