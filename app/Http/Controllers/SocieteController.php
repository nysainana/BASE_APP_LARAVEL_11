<?php

namespace App\Http\Controllers;

use App\Http\Requests\SocieteRequest;
use App\Models\Societe;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SocieteController extends Controller
{

    public function edit(Request $request)
    {
        $societe = Societe::first();

        return Inertia::render('Societe/Edit', [
            'societe' => $societe
        ]);
    }

    public function update(SocieteRequest $request, Societe $societe)
    {
        $data = $request->validated();
        $societe->update($data);
        return back()->with("message.success", "Enrégistrement effectuer.");
    }

    public function uploadLogo(Request $request, Societe $societe)
    {
        $request->validate([
            'logo_file' => "required|image|mimes:jpg,jpeg,png"
        ]);

        $url = $this->storeFile($request, "logo_file", $societe->nom, "images/logo/" . $societe->id);

        if($url) $societe->update([ 'logo' => $url ]);

        return back()->with("message.success", "Modification du logo réussie.");
    }

    public function deleteLogo(Request $request, Societe $societe)
    {
        $societe->update([ 'logo' => null ]);

        return back()->with("message.success", "Suppression du logo réussie.");
    }

}
