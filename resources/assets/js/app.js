/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the shownPage. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('passport-clients', require('./components/passport/Clients.vue'));

Vue.component('passport-authorized-clients', require('./components/passport/AuthorizedClients.vue'));

Vue.component('passport-personal-access-tokens', require('./components/passport/PersonalAccessTokens.vue'));

Vue.component('stats', require('./components/Stats.vue'));
Vue.component('products', require('./components/Products.vue'));

const app = new Vue({
    el: '#app',

    data: {
        'user': null,
        'categoriesCount': 0,
        'currentPage': 1
    },

    mounted() {
        //Echo.channel('products');

        this.$nextTick(() => {
            this.retrieveUser();
            this.prepareCartDropdown();
        });

        eventHub.$on('stats-received', this.handleStatsReceived);
        eventHub.$on('page-changed', this.handlePageChanged);
    },

    methods: {
        retrieveUser() {
            this.user = Laravel.user;
        },

        handleStatsReceived(stats) {
            this.categoriesCount = stats.categories;
        },

        handlePageChanged(page) {
            this.currentPage = page;
        },

        prepareCartDropdown() {
            $('li.dropdown.cart-dropdown > a').on('click', function (event) {
                $(this).parent().toggleClass("open");
            });

            $('body').on('click', function (e) {
                if (!$('li.dropdown.cart-dropdown').is(e.target) && $('li.dropdown.cart-dropdown').has(e.target).length === 0 && $('.open').has(e.target).length === 0) {
                    $('li.dropdown.cart-dropdown').removeClass('open');
                }
            });
        }
    }
});
