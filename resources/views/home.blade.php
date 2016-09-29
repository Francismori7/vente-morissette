@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-xs-12">
                <div class="jumbotron">
                    <h1 class="display-3">
                        Vos produits, à bons prix
                    </h1>
                    <p class="lead">Nous achetons des produits pour vous les revendre à un prix ridiculement bas. De
                        rien.</p>
                </div>

                <h3 class="page-header">Produits en vedette</h3>

                <div class="row">
                    @foreach($products as $product)
                        <div class="col-sm-6 col-xs-12">
                            <div class="card">
                                <img class="card-img-top w-100" src="//placehold.it/350x250" alt="Card image cap">
                                <div class="card-block">
                                    <h4 class="card-title flex-items-xs-between d-f">
                                        <span>{{ $product->name }}</span>
                                        <span class="tag tag-info flex-xs-top">
                                            {{ $product->asCurrency() }}
                                        </span>
                                    </h4>

                                    <p class="text-muted small">
                                        {{ ucfirst($product->created_at->diffForHumans()) }}
                                    </p>
                                    <p class="card-text">{{ $product->description }}</p>
                                    <a href="/produits/{{ $product->id }}" class="btn btn-primary btn-block">Détails</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-xs">
                        <hr>
                        <a href="/produits" class="btn btn-secondary btn-block">Voir tous les produits à vendre</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12">
                <div class="card">
                    <div class="card-header"><a href="/search">Rechercher un produit</a></div>
                    <div class="card-block">
                        <form action="{{ url('/produits') }}" method="get">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Termes..." name="search" required>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">
                                        <span class="fa fa-search"></span>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card no-top-down-borders">
                    <div class="card-header"><a href="/categories">Catégories</a></div>
                    <div class="list-group list-group-flush">
                        @forelse($categories as $category)
                            <a href="/categories/{{ Illuminate\Support\Str::lower($category->name) }}"
                               class="list-group-item list-group-item-action d-f flex-items-xs-between">
                                <span>{{ $category->name }}</span> <span
                                        class="tag tag-info pull-xs-right flex-xs-middle">{{ $category->products_count ?: '' }}</span>
                            </a>
                        @empty
                            <div class="list-group-item"><em>Aucune catégorie pour le moment...</em></div>
                        @endforelse
                        @if($stats->categories > \App\Category::countOnHomepage())
                            <a href="/categories" class="list-group-item list-group-item-action d-f">
                                <em>Plus de catégories...</em>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card">
                    <div class="card-header"><a href="/stats">Statistiques</a></div>
                    <div class="card-block">
                        <div class="stats">
                            <div class="stats-item">
                                <p class="heading">Catégories</p>
                                <p class="title">{{ $stats->categories }}</p>
                            </div>
                            <div class="stats-item">
                                <p class="heading">Produits</p>
                                <p class="title">{{ $stats->products }}</p>
                            </div>
                            <div class="stats-item">
                                <p class="heading">Usagers en ligne</p>
                                <p class="title">22</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">Paiements</div>
                    <div class="card-block">
                        <div class="text-xs-center">
                            <p class="lead"><span class="fa fa-3x fa-cc-paypal text-primary"></span><br>PayPal</p>
                            <p class="lead"><span class="fa fa-3x fa-credit-card text-warning"></span><br>Carte de
                                crédit</p>
                            <p class="lead"><span class="fa fa-3x fa-money text-success"></span><br>Argent comptant</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
