window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = require('jquery');
require('bootstrap');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue');
Vue.use(require('vue-resource'));

/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */

Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);

    next();
});
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
import Echo from "laravel-echo";


window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '74d2a5e78ffe9bd4d684'
});

Vue.http.interceptors.push((request, next ) => {
    next((response) => {
        if( 'Content-Type' in response.headers
            && response.headers['Content-Type'] == 'application/json' ){
            if( typeof response.data != 'object' ){
                response.data = JSON.parse( response.data );
            }
        }

        if( 'content-type' in response.headers
            && response.headers['content-type'] == 'application/json' ){
            if( typeof response.data != 'object' ){
                response.data = JSON.parse( response.data );
            }
        }
    });
});

(function(XHR) {
    "use strict";

    var send = XHR.prototype.send;

    XHR.prototype.send = function(data) {
        var self = this;
        var oldOnReadyStateChange;
        var url = this._url;
        this.setRequestHeader('Laravel-Inspector', 'interceptor-present');
        function onReadyStateChange() {
            if(self.readyState == 4 /* complete */) {
                var response = JSON.parse(this.response);
                if (typeof response.LARAVEL_INSPECTOR !== 'undefined') {
                    if(typeof response.LARAVEL_INSPECTOR === 'string')
                    {
                        eval(response.LARAVEL_INSPECTOR);
                    } else {
                        console.log('LARAVEL INSPECTOR ', response);
                    }
                }
            }
            if(oldOnReadyStateChange) {
                oldOnReadyStateChange();
            }
        }
        if(!this.noIntercept) {
            if(this.addEventListener) {
                this.addEventListener("readystatechange", onReadyStateChange, false);
            } else {
                oldOnReadyStateChange = this.onreadystatechange;
                this.onreadystatechange = onReadyStateChange;
            }
        }
        send.call(this, data);
    }
})(XMLHttpRequest);