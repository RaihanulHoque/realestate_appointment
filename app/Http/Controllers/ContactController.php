<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacts;
use Tymon\JWTAuth\Facades\JWTAuth;

class ContactController extends Controller
{
    protected $user;
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->user->contacts()->get()->toArray();
    }

    public function show($id)
    {
        $contact = $this->user->contacts()->find($id);

        if (!$contact) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Contact with cannot be found'
            ], 400);
        }

        return $contact;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string|max:7'
        ]);

        $contact = new Contacts();
        $contact->created_by= $request->user()->id;
        $contact->name= $request->name;
        $contact->surname= $request->surname;
        $contact->email= $request->email;
        $contact->phone= $request->phone;
        $contact->address= str_replace(' ', '', $request->address);

        if ($this->user->contacts()->save($contact))
            return response()->json([
                'success' => true,
                'contact' => $contact
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, contact could not be added'
            ], 500);
    }

    public function update(Request $request, $id)
    {
        $contact = $this->user->contacts()->find($id);
        if (!$contact) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, contact with id ' . $contact . ' cannot be found'
            ], 400);
        }

        $updated = $contact->fill($request->all())
            ->save();

        if ($updated) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, contact could not be updated'
            ], 500);
        }

    }

    public function destroy($id)
    {
        $contact = $this->user->contacts()->find($id);

        if (!$contact) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, contact with id ' . $id . ' cannot be found'
            ], 400);
        }

        if ($contact->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'contact could not be deleted'
            ], 500);
        }
    }


}
