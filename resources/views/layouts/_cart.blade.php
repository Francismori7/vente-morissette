<li class="dropdown cart-dropdown nav-item pull-xs-none pull-md-left">
    <a href="#" class="dropdown-toggle nav-link">
        <span class="fa fa-shopping-cart"></span>
    </a>

    <div class="dropdown-menu cart-dropdown-menu" role="menu">
        <div class="container">
            <h4>Panier</h4>

            <div class="row">
                <div class="col-xs">
                    <ul class="list-group">
                        <li class="list-group-item product">
                            {{--
                            <div class="product-quantity">
                                <span class="tag tag-primary">
                                    2 <span class="fa fa-times"></span>
                                </span>
                            </div>
                            --}}
                            <div class="product-name">
                                <a href="{{ route('products.show', 1) }}">PRODUIT #2</a>
                            </div>
                            <div class="product-price">
                                <span class="tag tag-success">{{ currency(1398) }}</span>
                                <a href="#" class="tag tag-danger"><span class="fa fa-times"></span></a>
                            </div>
                        </li>
                        <li class="list-group-item product">
                            <div>
                                <em>Votre panier est vide...</em>
                            </div>
                            <div>
                                <a href="{{ route('products.index') }}" class="btn btn-success btn-sm">Ajoutez des
                                    items!</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row cart-options">
                <div>
                    <a href="{{ url('/cart') }}" class="btn btn-link">Voir le panier</a>
                </div>
                <div class="p-r-1">
                    <span class="tag tag-info">{{ currency(1398) }}</span>
                </div>
            </div>

            <div class="row cart-checkout">
                <div class="p-r-1">
                    <a href="{{ url('/cart/checkout') }}" class="btn btn-primary"><span class="fa fa-dollar"></span>
                        Réserver<</a>
                </div>
            </div>
        </div>
    </div>
</li>