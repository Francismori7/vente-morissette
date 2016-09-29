<div class="card">
    <a href="{{ route('products.show', $product) }}">
        <img class="card-img-top w-100" src="//placehold.it/350x250" alt="{{ $product->name }}">
    </a>
    <div class="card-block">
        <h4 class="card-title flex-items-xs-between d-f">
            <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
            <span class="tag tag-success flex-xs-top">
                {{ $product->asCurrency() }}
            </span>
        </h4>

        <p class="text-muted small">
            {{ ucfirst($product->created_at->diffForHumans()) }}
        </p>
        <p class="card-text">{{ $product->description }}</p>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-xs">
                <a href="{{ route('products.show', $product) }}" class="btn btn-primary btn-block">Détails</a>
            </div>
            <div class="col-xs-3">
                <button class="btn btn-warning btn-block"><span class="fa fa-cart-plus"></span></button>
            </div>
        </div>

    </div>
</div>