<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContentFormRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function contactadd(ContentFormRequest $request){



        $data = $request->all();
        $lastsaveddata =Contact::create($data);

        return back()->withSuccess(['message'=>'Başarıyla Gönderildi']);

    }
}
