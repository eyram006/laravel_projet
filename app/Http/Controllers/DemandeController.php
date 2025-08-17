<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use Illuminate\Http\Request;
use App\Models\Assure;
use App\Enums\StatutEnum;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $demandes = Demande::with('assure')->paginate();
        return view('demandes.index', compact('demandes'));
    }

    

    /**
     * Show the form for creating a new resource.
     */
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validation des données
            $validator = Validator::make($request->all(), [
                'donnees_medicales' => 'required|array',
                'donnees_medicales.informations_personnelles' => 'required|array',
                'donnees_medicales.informations_personnelles.nom' => 'required|string|max:255',
                'donnees_medicales.informations_personnelles.prenom' => 'required|string|max:255',
                'donnees_medicales.informations_personnelles.date_naissance' => 'required|date|before:today',
                'donnees_medicales.informations_personnelles.sexe' => 'required|in:M,F',
                
                // Informations socio-démographiques
                'donnees_medicales.informations_sociodemographiques' => 'required|array',
                'donnees_medicales.informations_sociodemographiques.email' => 'required|email|max:255',
                'donnees_medicales.informations_sociodemographiques.telephone' => 'required|string|max:20',
                'donnees_medicales.informations_sociodemographiques.quartier' => 'required|string|max:255',
                'donnees_medicales.informations_sociodemographiques.profession' => 'required|string|max:255',
                
                // Antécédents médicaux
                'donnees_medicales.antecedents_medicaux' => 'required|array',
                'donnees_medicales.antecedents_medicaux.depenses_mensuelles_sante' => 'required|numeric|min:0',
                
                // Validation conditionnelle pour la section gynécologique
                'donnees_medicales.gynecologie' => 'required_if:donnees_medicales.informations_personnelles.sexe,F|array',
                'donnees_medicales.gynecologie.age_premieres_regles' => 'required_if:donnees_medicales.informations_personnelles.sexe,F|numeric|min:8|max:20',
                'donnees_medicales.gynecologie.nombre_grossesses' => 'required_if:donnees_medicales.informations_personnelles.sexe,F|numeric|min:0',
                'donnees_medicales.gynecologie.nombre_accouchements' => 'required_if:donnees_medicales.informations_personnelles.sexe,F|numeric|min:0',
            ], [
                // Messages d'erreur personnalisés
                'donnees_medicales.required' => 'Les données médicales sont obligatoires.',
                'donnees_medicales.informations_personnelles.nom.required' => 'Le nom est obligatoire.',
                'donnees_medicales.informations_personnelles.prenom.required' => 'Le prénom est obligatoire.',
                'donnees_medicales.informations_personnelles.date_naissance.required' => 'La date de naissance est obligatoire.',
                'donnees_medicales.informations_personnelles.date_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui.',
                'donnees_medicales.informations_personnelles.sexe.required' => 'Le sexe est obligatoire.',
                'donnees_medicales.informations_personnelles.sexe.in' => 'Le sexe doit être M ou F.',
                'donnees_medicales.informations_sociodemographiques.email.required' => 'L\'email est obligatoire.',
                'donnees_medicales.informations_sociodemographiques.email.email' => 'L\'email doit être valide.',
                'donnees_medicales.informations_sociodemographiques.telephone.required' => 'Le téléphone est obligatoire.',
                'donnees_medicales.antecedents_medicaux.depenses_mensuelles_sante.required' => 'Les dépenses mensuelles de santé sont obligatoires.',
                'donnees_medicales.antecedents_medicaux.depenses_mensuelles_sante.numeric' => 'Les dépenses mensuelles doivent être un nombre.',
                'donnees_medicales.antecedents_medicaux.depenses_mensuelles_sante.min' => 'Les dépenses mensuelles ne peuvent pas être négatives.',
                'donnees_medicales.gynecologie.required_if' => 'Les informations gynécologiques sont obligatoires pour les femmes.',
                'donnees_medicales.gynecologie.age_premieres_regles.required_if' => 'L\'âge des premières règles est obligatoire pour les femmes.',
                'donnees_medicales.gynecologie.age_premieres_regles.min' => 'L\'âge des premières règles doit être au minimum 8 ans.',
                'donnees_medicales.gynecologie.age_premieres_regles.max' => 'L\'âge des premières règles doit être au maximum 20 ans.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreurs de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            // Recherche ou création de l'assuré
            $donneesPersonnelles = $request->input('donnees_medicales.informations_personnelles');
            $donneesContact = $request->input('donnees_medicales.informations_sociodemographiques');

            
           $user = auth()->guard('web')->user();
           $assure = optional($user)->assure ?? Assure::create([
    'email' => optional($user)->email,
    'nom' => $donneesPersonnelles['nom'],
                    'prenom' => $donneesPersonnelles['prenom'],
                    'date_naissance' => $donneesPersonnelles['date_naissance'],
                    'sexe' => $donneesPersonnelles['sexe'],
                    'telephone' => $donneesContact['telephone'],
                    'quartier' => $donneesContact['quartier'] ?? null,
                    'profession' => $donneesContact['profession'] ?? null,
                ]
            );

            // Préparation des données pour la colonne 'reponses'
            $reponses = $this->prepareReponsesData($request->input('donnees_medicales'));

            // Création de la demande
            $demande = Demande::create([
                'assure_id' => $assure->id,
                'reponses' => $reponses,
                'statut' => 'EN_ATTENTE', // ou la valeur par défaut de votre enum
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Demande créée avec succès',
                'data' => [
                    'demande_id' => $demande->id,
                    'assure_id' => $assure->id,
                    'statut' => $demande->statut->value ?? $demande->statut,
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la création de la demande: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur interne du serveur',
                'error' => config('app.debug') ? $e->getMessage() : 'Une erreur est survenue'
            ], 500);
        }
    }

    /**
     * Prépare les données médicales pour la colonne 'reponses'
     */
    private function prepareReponsesData(array $donneesMedicales): array
    {
        // Structuration des données selon vos besoins métier
        $reponses = [
            'informations_personnelles' => $donneesMedicales['informations_personnelles'] ?? [],
            'informations_sociodemographiques' => $donneesMedicales['informations_sociodemographiques'] ?? [],
            'couverture_sante' => $donneesMedicales['couverture_sante'] ?? [],
            'contact_urgence' => $donneesMedicales['contact_urgence'] ?? [],
            'antecedents_medicaux' => $donneesMedicales['antecedents_medicaux'] ?? [],
            'allergies_antecedents' => $donneesMedicales['allergies_antecedents'] ?? [],
            'mode_vie' => $donneesMedicales['mode_vie'] ?? [],
            'date_soumission' => now()->toISOString(),
            'version_formulaire' => '1.0'
        ];

        // Ajout conditionnel de la section gynécologique
        if (isset($donneesMedicales['gynecologie']) && !empty($donneesMedicales['gynecologie'])) {
            $reponses['gynecologie'] = $donneesMedicales['gynecologie'];
        }

        // Nettoyage des données vides
        return $this->cleanEmptyValues($reponses);
    }

    /**
     * Nettoie les valeurs vides du tableau
     */
    private function cleanEmptyValues(array $data): array
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->cleanEmptyValues($value);
                if (empty($data[$key])) {
                    unset($data[$key]);
                }
            } elseif (is_string($value) && trim($value) === '') {
                unset($data[$key]);
            } elseif (is_null($value)) {
                unset($data[$key]);
            }
        }
        return $data;
    }

    /**
     * Affiche le formulaire de création
     */
    // public function create()
    // {
    //     return view('demandes.create');
    // }

    /**
     * Affiche une demande spécifique
     */
    public function show(Demande $demande)
    {
        $demande->load('assure');
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $demande->id,
                'assure' => $demande->assure,
                'reponses' => $demande->reponses,
                'statut' => $demande->statut,
                'created_at' => $demande->created_at,
                'updated_at' => $demande->updated_at,
            ]
        ]);
    }

    /**
     * Met à jour le statut d'une demande
     */
    public function updateStatus(Request $request, Demande $demande)
    {
        $request->validate([
            'statut' => 'required|string'
        ]);

        try {
            $demande->update([
                'statut' => $request->statut
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Statut mis à jour avec succès',
                'data' => [
                    'demande_id' => $demande->id,
                    'nouveau_statut' => $demande->statut
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour du statut: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du statut'
            ], 500);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Demande $demande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Demande $demande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Demande $demande)
    {
        //
    }
}
