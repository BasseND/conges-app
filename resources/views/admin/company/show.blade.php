<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Informations de la société') }}
    </h2>
</x-slot>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Informations de la société</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('welcome.index') }}">Accueil</a></li>
                            <li class="breadcrumb-item active">Société</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Détails de la société</h4>
                            @if($company)
                                <a href="{{ route('admin.company.edit') }}" class="btn btn-primary">
                                    <i class="bx bx-edit-alt me-1"></i> Modifier
                                </a>
                            @else
                                <a href="{{ route('admin.company.create') }}" class="btn btn-success">
                                    <i class="bx bx-plus me-1"></i> Créer
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        @if($company)
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="text-center">
                                        @if($company->logo)
                                            <img src="{{ Storage::url($company->logo) }}" alt="Logo de la société" class="img-fluid rounded" style="max-height: 200px;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                                <i class="bx bx-building text-muted" style="font-size: 4rem;"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="table-responsive">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <th class="ps-0" scope="row">Nom de la société :</th>
                                                    <td class="text-muted">{{ $company->name }}</td>
                                                </tr>
                                                @if($company->description)
                                                <tr>
                                                    <th class="ps-0" scope="row">Description :</th>
                                                    <td class="text-muted">{{ $company->description }}</td>
                                                </tr>
                                                @endif
                                                @if($company->address)
                                                <tr>
                                                    <th class="ps-0" scope="row">Adresse :</th>
                                                    <td class="text-muted">
                                                        {{ $company->address }}
                                                        @if($company->city || $company->postal_code)
                                                            <br>
                                                            {{ $company->postal_code }} {{ $company->city }}
                                                        @endif
                                                        @if($company->country)
                                                            <br>
                                                            {{ $company->country }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endif
                                                @if($company->location)
                                                <tr>
                                                    <th class="ps-0" scope="row">Localisation :</th>
                                                    <td class="text-muted">{{ $company->location }}</td>
                                                </tr>
                                                @endif
                                                @if($company->contact_email)
                                                <tr>
                                                    <th class="ps-0" scope="row">Email de contact :</th>
                                                    <td class="text-muted">
                                                        <a href="mailto:{{ $company->contact_email }}">{{ $company->contact_email }}</a>
                                                    </td>
                                                </tr>
                                                @endif
                                                @if($company->contact_phone)
                                                <tr>
                                                    <th class="ps-0" scope="row">Téléphone :</th>
                                                    <td class="text-muted">
                                                        <a href="tel:{{ $company->contact_phone }}">{{ $company->contact_phone }}</a>
                                                    </td>
                                                </tr>
                                                @endif
                                                @if($company->currency)
                                                <tr>
                                                    <th class="ps-0" scope="row">Devise :</th>
                                                    <td class="text-muted">{{ $company->currency }}</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bx bx-building text-muted" style="font-size: 4rem;"></i>
                                <h5 class="mt-3">Aucune information de société configurée</h5>
                                <p class="text-muted">Cliquez sur le bouton "Créer" pour ajouter les informations de votre société.</p>
                                <a href="{{ route('admin.company.create') }}" class="btn btn-success">
                                    <i class="bx bx-plus me-1"></i> Créer les informations de la société
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
