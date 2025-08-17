{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard - AssuranceApp')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Tableau de bord</h1>
            
            {{-- Contenu du dashboard ici --}}
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                Bienvenue sur votre dashboard sunuSante !
            </div>
            
            {{-- Exemple de cartes statistiques --}}
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-users fa-2x text-primary"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="small text-muted">Employés</div>
                                    <div class="h4 mb-0">{{ $totalEmployees ?? '0' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-file-alt fa-2x text-success"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="small text-muted">Demandes</div>
                                    <div class="h4 mb-0">{{ $totalDemandes ?? '0' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-file-contract fa-2x text-warning"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="small text-muted">Polices</div>
                                    <div class="h4 mb-0">{{ $totalPolices ?? '0' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-user-tie fa-2x text-info"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="small text-muted">Gestionnaires</div>
                                    <div class="h4 mb-0">{{ $totalGestionnaires ?? '0' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Scripts spécifiques au dashboard
    console.log('Dashboard loaded');
</script>
@endpush
