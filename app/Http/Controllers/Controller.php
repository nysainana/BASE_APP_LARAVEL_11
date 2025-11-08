<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Variation;

abstract class Controller
{

    public function storeFile(Request $request, String $data_index, String $fileName, String $folder, String $extension = null)
    {
        if($file = $request->file($data_index))
        {
            $fileName = Str::slug($fileName, '_') . '_' . Carbon::now()->getTimestampMs() . '.' . ($extension ?? $file->getClientOriginalExtension());

            Storage::disk('public')->putFileAs($folder, $file, $fileName);

            return "/storage/$folder/$fileName";
        }

        return null;
    }

    protected function setMultiRelations($object, $relation, $data)
    {
        $in = array_map(fn ($e) => $e['id'] ?? null, $data);

        $object->$relation->each(function($e) use ($in) {
            if (!in_array($e->id, $in)) $e->delete();
        });

        foreach ($data as $datum) {
            $object->$relation()->updateOrCreate(
                ['id' => $datum['id']],
                $datum
            );
        }
    }

    protected function calculeMontant(
        $data,
        $details_key = 'details',
        $tva_key = 'tva',
        $variation_id_key = 'variation_id',
        $quantite_key = 'quantite',
        $prix_unitaire_key = 'prix_unitaire',
        $ecrase_prix_unitaire = true,
        $variation_class = Variation::class,
        $variation_pix_unitaire_key = 'prix_unitaire'
    ) {
        // Initialisation des montants
        $data["montant_ht"] = 0;
        $data["montant_tva"] = 0;
        $data["montant_ttc"] = 0;


        // Récupérer toutes les variations en une seule requête
        $variationIds = array_column($data[$details_key], $variation_id_key);
        $variations = $variation_class::whereIn('id', $variationIds)->get()->keyBy('id');

        // Traitement des détails
        $data[$details_key] = array_map(function ($d) use (
            &$data,
            $variations,
            $variation_id_key,
            $quantite_key,
            $prix_unitaire_key,
            $ecrase_prix_unitaire,
            $variation_pix_unitaire_key
        ) {

            $variation = $variations[$d[$variation_id_key]];

            $prixUnitaire = ($ecrase_prix_unitaire || !$d[$prix_unitaire_key]) ? $variation->{$variation_pix_unitaire_key} : $d[$prix_unitaire_key];
            $montant = $prixUnitaire * $d[$quantite_key];
            $data["montant_ht"] += $montant;

            return array_merge($d, [
                "prix_unitaire" => $prixUnitaire,
                "montant" => $montant,
            ]);
        }, $data[$details_key]);

        // Calculs des montants
        $data["montant_tva"] = $data["montant_ht"] * ($data[$tva_key] / 100);
        $data["montant_ttc"] = $data["montant_ht"] + $data["montant_tva"];

        if(isset($data['remise']) && $data['remise'] > 0) {
            if (isset($data['unite_remise']) && $data['unite_remise'] === '%') {
                $montantRemise = $data["montant_ttc"] * ($data['remise'] / 100);
            } else {
                $montantRemise = $data['remise'];
            }
            $data["montant_total"] = $data["montant_ttc"] - $montantRemise;
            $data["montant_remise"] = $montantRemise;
        } else {
            $data['remise'] = 0;
            $data["montant_remise"] = 0;
            $data["montant_total"] = $data["montant_ttc"];
        }

        return $data;
    }

}
