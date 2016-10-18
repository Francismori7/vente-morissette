<template>
    <div>
        <div class="row" v-if="refreshing">
            <div class="col-xs">
                <div class="alert alert-info">
                    <span class="fa fa-circle-o-notch fa-spin"></span> Chargement en cours de la page {{ currentPage
                    }}...
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs col-sm col-md-4" v-for="product in products">
                {{ product.name }}
            </div>
        </div>
        <div class="row" v-if="pagination">
            <div class="col-xs">
                <ul class="pagination">
                    <li class="page-item" :class="{ disabled: currentPage == 1 }">
                        <a class="page-link" :href="pageLink(currentPage - 1 > 0 ? currentPage - 1 : 1)"
                           @click="goToPage(currentPage - 1)">&laquo;</a>
                    </li>
                    <li v-for="page in pages" class="page-item" :class="{ active: page.active }">
                        <a class="page-link" :href="pageLink(page.id)" @click="goToPage(page.id)">{{ page.id }}</a>
                    </li>
                    <li class="page-item" :class="{ disabled: currentPage == pagination.total_pages }">
                        <a class="page-link" :href="pageLink(currentPage + 1)"
                           @click="goToPage(currentPage + 1)">&raquo;</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                products: null,
                shownPage: null,
                pagination: null,
                pages: [],
                refreshing: true
            };
        },

        mounted() {
            this.retrieveProducts();
        },

        methods: {
            retrieveProducts() {
                this.pageRequest();
            },
            getQueryString(field) {
                let href = window.location.href,
                    reg = new RegExp('[?&]' + field + '=([^&#]*)', 'i'),
                    string = reg.exec(href);

                return string ? string[1] : null;
            },
            goToPage(page) {
                event.preventDefault();

                if (!this.canGoToPage(page)) {
                    return;
                }

                this.shownPage = page;
                this.pageRequest();
            },
            canGoToPage(page) {
                return !(page === 0 || page > this.pagination.total_pages || page === this.currentPage);
            },
            buildPages(response) {
                console.log(response);
                let pages = [];
                for (let i = 1; i <= response.data.meta.pagination.total_pages; i++) {
                    let active = response.data.meta.pagination.current_page === i;
                    let page = {id: i, active: active};
                    pages.push(page);
                }
                this.pages = pages;
                this.shownPage = response.data.meta.pagination.current_page;
            },
            pageRequest() {
                this.refreshing = true;
                this.$http.get(`/api/products?page=${this.currentPage}`)
                    .then((response) => {
                        this.pagination = response.data.meta.pagination;
                        this.buildPages(response);
                        this.fillProducts(response);
                        eventHub.$emit('products-received', this.products);
                    });
            },
            fillProducts(response) {
                this.products = response.data.data;
                this.refreshing = false;
            },
            pageLink(page) {
                return '?page=' + page;
            }
        },
        computed: {
            currentPage() {
                return this.shownPage || this.getQueryString('page') || 1;
            }
        }
    }
</script>
