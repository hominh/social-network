
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app',
    data: {
        posts: [],
        title: 'Update new posts'
    },
    created() {
        console.log('created');
      //do something after creating vue instance
        //this.fetchPosts();
        this.fetchPosts();

    },

    methods: {
        fetchPosts() {
            axios.get('/post/lists')
            .then(response => {
                this.posts = response.data;
                console.log(response);

            })
            .catch(function(error){
                console.log(error);
            });
        },
        addPost() {
            axios.post('/post/store',{
            content: this.content
        })
        .then(function (response){
            console.log(response);
            alert('success');
        })
        .catch(function (error){
            console.log(error);
        })
      }
    }
});
