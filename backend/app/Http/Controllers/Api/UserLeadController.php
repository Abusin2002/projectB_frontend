<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserLeadController extends Controller
{
    // Create a new lead (contact form submission)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name'  => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'message'        => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $lead = UserLead::create($request->only([
            'customer_name', 'customer_phone', 'customer_email', 'message'
        ]));

        return response()->json([
            'status'  => true,
            'message' => 'Lead submitted successfully.',
            'data'    => $lead
        ], 201);
    }

   
// Get all leads with pagination
public function index()
{
    $leads = UserLead::latest()->paginate(15);

    return response()->json([
        'status' => true,
        'data'   => $leads->items(), // Current page data
        'pagination' => [
            'current_page' => $leads->currentPage(),
            'per_page'     => $leads->perPage(),
            'total'        => $leads->total(),
            'last_page'    => $leads->lastPage(),
            'next_page_url'=> $leads->nextPageUrl(),
            'prev_page_url'=> $leads->previousPageUrl(),
        ]
    ]);
}



     // Delete a lead
    public function destroy($id)
    {
        $lead = UserLead::find($id);

        if (!$lead) {
            return response()->json([
                'status'  => false,
                'message' => 'Lead not found.'
            ], 404);
        }

        $lead->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Lead deleted successfully.'
        ]);
    }
}
