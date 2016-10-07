<template>
    <div class="card">
        <div class="card-header"><a href="/stats">Statistiques</a></div>
        <div class="card-block">
            <div class="stats">
                <div class="stats-item">
                    <p class="heading"><a href="/stats#categories">Catégories</a>
                    </p>
                    <p class="title" id="categories">
                        <span class="fa fa-spin fa-circle-o-notch" v-if="!stats.categories"></span>
                        <span v-else>{{ stats.categories }}</span>
                    </p>
                </div>
                <div class="stats-item">
                    <p class="heading"><a href="/stats#products">Produits</a></p>
                    <p class="title" id="products">
                        <span class="fa fa-spin fa-circle-o-notch" v-if="!stats.products"></span>
                        <span v-else>{{ stats.products }}</span>
                    </p>
                </div>
                <div class="stats-item">
                    <p class="heading"><a href="/stats#users">Usagers</a></p>
                    <p class="title" id="users">
                        <span class="fa fa-spin fa-circle-o-notch" v-if="!stats.users"></span>
                        <span v-else>{{ stats.users }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                stats: {
                    categories: null,
                    products: null,
                    users: null
                }
            }
        },
        mounted() {
            this.retrieveStats();
        },
        methods: {
            retrieveStats() {
                this.$http.get('/api/stats').then(response => {
                    this.stats = response.data.data;
                    eventHub.$emit('stats-received', this.stats);
                });
            }
        }
    }
</script>
