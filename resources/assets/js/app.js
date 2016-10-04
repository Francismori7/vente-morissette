/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */


const app = new Vue({
    el: '#app',

    data: {
        'user': null
    },

    mounted() {
        //Echo.channel('products');

        this.$nextTick(() => {
            this.prepareCartDropdown();
            this.retrieveUser();
        });
    },

    methods: {
        retrieveUser() {
            this.user = Laravel.user;
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
    },

    computed: {
        userAvatar() {
            return this.user ? this.user.avatar : '';
        }
    }
});
