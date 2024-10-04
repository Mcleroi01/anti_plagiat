<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\User;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function showRenewalForm($id)
    {
        // Trouver l'utilisateur par son id
        $user = User::findOrFail($id);

        // Récupérer les informations de crédit de l'utilisateur (si elles existent)
        $credit = Credit::where('user_id', $user->id)->first();

        return view('credits.renewal', compact('user', 'credit'));
    }

    public function renewCredits(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'credits' => 'required|integer|min:1',
        ]);

        // Récupère l'utilisateur et son crédit
        $user = User::find($request->user_id);
        $credit = Credit::firstOrCreate(['user_id' => $user->id]);

        // Met à jour le crédit
        $credit->monthly_limit = $request->credits;
        $credit->documents_uploaded = 0; // Réinitialise le nombre de documents uploadés
        $credit->save();

        return redirect()->back()->with('success', 'Crédits mis à jour avec succès !');
    }
}
