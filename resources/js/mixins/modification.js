export default {
    data () {
        return {
            editing: false
        }
    },

    methods: {
        edit () {
            this.setEditCache();
            this.editing = true;
        },

        cancel (){
            this.restoreFromCache();
            this.editing = false;
        },
        setEditCache () {},
        restoreFromCache () {},

        update () {
            axios.patch(this.endpoint, this.payload())
                .then(res => {
                    console.log(res);
                    this.editing = false;
                    this.bodyHtml = res.data.body_html;
                    this.$toast.success(res.data.message, "Success", {timeout: 3000});
                }) // If ajax call is successful
                .catch( err => {
                    this.$toast.error(err.response.data.message, "Error", {timeout: 3000});
                }); // If ajax call is fails
        },
        payload(){},

        destroy () {

            this.$toast.question('Are you sure about that?', "Confirm",{
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Hey',
                message: 'Are you sure about that?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>',  (instance, toast) => {

                      this.delete();

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }, true],
                    ['<button>NO</button>', function (instance, toast) {

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }],
                ]
            });

        },

        delete () {},
    }
}
