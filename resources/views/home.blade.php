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
                    <div class="col-xs">
                        @foreach($products->chunk(2) as $chunk)
                            <div class="card-deck">
                                @foreach($chunk as $product)
                                    @include('products._card', compact('product'))
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs">
                        <hr>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-block">Voir tous les
                            produits à vendre</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12">
                <div class="card">
                    <div class="card-header"><a href="{{ route('search') }}">Rechercher un produit</a></div>
                    <div class="card-block">
                        <form action="{{ route('products.index') }}" method="get">
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
                    <div class="card-header"><a href="{{ route('categories.index') }}">Catégories</a></div>
                    <div class="list-group list-group-flush">
                        @forelse($categories as $category)
                            <a href="{{ route('categories.show', $category) }}"
                               class="list-group-item list-group-item-action d-f flex-items-xs-between">
                                <span>{{ $category->name }}</span> <span
                                        class="tag tag-info pull-xs-right flex-xs-middle">{{ $category->products_count ?: '' }}</span>
                            </a>
                        @empty
                            <div class="list-group-item"><em>Aucune catégorie pour le moment...</em></div>
                        @endforelse

                        <a href="{{ route('categories.index') }}"
                           v-if="categoriesCount > {{ \App\Category::countOnHomepage() }}"
                           class="list-group-item list-group-item-action d-f">
                            <em>Plus de catégories...</em>
                        </a>
                    </div>
                </div>
                <stats></stats>
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
