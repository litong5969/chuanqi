
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
//
// window.Vue = require('vue');
//
// /**
//  * Next, we will create a fresh Vue application instance and attach it to
//  * the page. Then, you may begin adding components to this application
//  * or customize the JavaScript scaffolding to fit your unique needs.
//  */
//
Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('article-follow-button', require('./components/ArticleFollowButton.vue'));
Vue.component('user-follow-button', require('./components/UserFollowButton.vue'));
Vue.component('user-vote-button', require('./components/UserVoteButton.vue'));
Vue.component('send-message', require('./components/SendMessage.vue'));
Vue.component('comments', require('./components/Comments.vue'));
Vue.component('user-avatar', require('./components/Avatar.vue'));


import Icon from 'vue-svg-icon/Icon.vue';
Vue.component('icon', Icon);

const app = new Vue({
    el: '#app'
});
