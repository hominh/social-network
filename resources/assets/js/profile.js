
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
        messages: function(id) {
            axios.get('message/'+id)
            .then(response => {
                console.log(response.data);
                app.singlemessages = response.data;
                app.conversation_id = response.data[0].conversation_id;
            })
            .catch(function(error){
                console.log(error);
            })
        },
        inputHandler(e) {
            if(e.keyCode === 13 && !e.shiftKey) {
                this.sendMessage();
            }
        },
        sendMessage() {
            if(this.messagefrom) {
                axios.post('/message/store',{
                    conversation_id: this.conversation_id,
                    content: this.messagefrom,

                })
                .then(function (response){
                    console.log(response);
                    alert('success');
                    if(response.status == 200) {
                        app.singlemessages = response.data;

                    }
                    else {
                        console.log(response.status);
                    }
                })
                .catch(function (error){
                    console.log(error);
                })
            }
        },
        friendId: function(id) {
            app.friend_id = id;
        },
        sendNewMsg() {
            console.log('new conversation');
            axios.post('/message/newmessage',{
                friend_id: this.friend_id,
                content: this.newmessagefrom
            })
            .then(function(response){
                console.log(response.data);
                console.log('success');
            })
            .catch(function(error){
                console.log(error);
            });
        }
    }
});
