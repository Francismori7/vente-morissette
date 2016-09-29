@extends('layouts.app')

@section('title', 'Produits - Page ' . Request::query('page', 1))

@section('content')
    <div class="container">
        <h1 class="page-header">Liste des produits</h1>
        <div class="row">
            <div class="col-xs">
                @foreach($products->chunk(3) as $chunk)
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
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection