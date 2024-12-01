<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;

class ContactController extends Controller
{
      /**
     * Handle the contact request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function contact(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'work_email' => 'required|email',
        'message' => 'required|string',
      ]);

      if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
      }

      $contact = new Contact();
      $contact->first_name = $request->input('first_name');
      $contact->last_name = $request->input('last_name');
      $contact->work_email = $request->input('work_email');
      $contact->message = $request->input('message');
      $contact->save();

      return response()->json(['message' => 'Contact successful!'], 200);

    }

    // Function to get all contacts
    public function getAllContacts()
    {
        $contacts = Contact::all();

        $contactsArray = $contacts->toArray();

        return response()->json(['contacts' => $contactsArray], 200);
    }
}
