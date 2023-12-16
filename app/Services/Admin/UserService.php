<?php
namespace App\Services\Admin;

use Illuminate\Support\Facades\Hash;

class UserService
{

    public function handle($user, $request)
    {
        // Негізгі ақпарат
        $user->full_name = $request->full_name;
        $user->iin = $request->iin;
        $user->nomer_card = $request->nomer_card;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->place_live = $request->place_live;
        if($request->role == 3){
            // Студенттерге ақпарат
            $user->family = $request->family;
            $user->type_study = $request->type_study;
            $user->course = $request->course;
            $user->group = $request->group;
            $user->parents = $request->parents;
            $user->parents_phone = $request->parents_phone;
            $user->parents_work = $request->parents_work;
            $user->certificates = $request->certificates;
            $user->disability = $request->disability;
            $user->hobby = $request->hobby;
            $user->faith = $request->faith;
        }
        if($request->role == 2){
            // Мұғалімдерге ақпарат
            $user->type_publication = $request->type_publication;
            $user->name_publication = $request->name_publication;
            $user->created_at_publication = $request->created_at_publication;
            $user->nomer_publication = $request->nomer_publication;
            $user->authors_publication = $request->authors_publication;
            $user->certificate_type = $request->certificate_type;
            $user->kurmet = $request->kurmet;
            $user->certification_at = $request->certification_at;
            $user->form_cualification = $request->form_cualification;
            $user->city = $request->city;
            $user->place_work = $request->place_work;
            $user->start_date = $request->start_date;
            $user->end_date = $request->end_date;
            $user->duration_work = $request->duration_work;
            $user->title = $request->title;
            $user->document_verification_type = $request->document_verification_type;
        }
        return $user;
    }

    public function save($user, $request)
    {
        $user = $this->handle($user, $request);
        return $user->save();
    }
}
