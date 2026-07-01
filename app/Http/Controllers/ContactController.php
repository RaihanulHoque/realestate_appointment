<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacts;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use App\Traits\ApiResponser;

class ContactController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return ContactResource::collection($request->user()->contacts()->get());
    }

    public function show(Request $request, $id)
    {
        $contact = $request->user()->contacts()->find($id);

        if (!$contact) {
            return $this->notFoundResponse('contact', $id);
        }

        $this->authorize('view', $contact);

        return new ContactResource($contact);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactRequest $request)
    {
        $contact = new Contacts();
        $contact->created_by = $request->user()->id;
        $contact->name = $request->name;
        $contact->surname = $request->surname;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->address = str_replace(' ', '', $request->address);

        if ($request->user()->contacts()->save($contact)) {
            return $this->successResponse(['contact' => new ContactResource($contact)]);
        }

        return $this->errorResponse('Sorry, contact could not be added', 500);
    }

    public function update(UpdateContactRequest $request, $id)
    {
        $contact = $request->user()->contacts()->find($id);
        if (!$contact) {
            return $this->notFoundResponse('contact', $id);
        }

        $this->authorize('update', $contact);

        $updated = $contact->fill($request->validated())->save();

        if ($updated) {
            return $this->successResponse();
        }

        return $this->errorResponse('Sorry, contact could not be updated', 500);
    }

    public function destroy(Request $request, $id)
    {
        $contact = $request->user()->contacts()->find($id);

        if (!$contact) {
            return $this->notFoundResponse('contact', $id);
        }

        $this->authorize('delete', $contact);

        if ($contact->delete()) {
            return $this->successResponse();
        }

        return $this->errorResponse('contact could not be deleted', 500);
    }
}
