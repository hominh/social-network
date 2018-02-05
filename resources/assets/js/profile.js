
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
        title: 'Click on user from left side:',
        content: '',
        privatemessages:[],
        singlemessages:[],
        messagefrom:'',
        conversation_id:'',
        friend_id:'',
        seen: false,
        newmessagefrom:''
    },
    created() {
        console.log('createds');
      //do something after creating vue instance
        this.fetchMessages();

    },

    methods: {
        fetchMessages() {
            axios.get('/message/lists')
            .then(response => {
                this.privatemessages = response.data;
                console.log(response);

            })
            .catch(function(error){
                console.log(error);
            });
        },
        addMessage() {
            axios.post('/post/store',{
            content: this.content
        })
        .then(function (response){
            console.log(response);
            alert('success');
            if(response.status == 200) {
                app.posts = response.data;

            }
            else {
                console.log(response.status);
            }
        })
        .catch(function (error){
            console.log(error);
        })
      }
    }
});
