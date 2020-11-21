
<script>
    export default {
        props: ['answer'],

        data() {
            return {
                editing: false,
                body: this.answer.body,
                bodyHtml: this.answer.body_html,
                id: this.answer.id,
                questionId: this.answer.question_id,
                beforeEditCache: null,
            }

        },

        methods: {
            edit () {
                this.beforeEditCache = this.body;
                this.editing = true;
            },

            cancel (){
              this.body = this.beforeEditCache;
              this.editing = false;
            },

            update () {
                axios.patch(this.endpoint, {
                    body: this.body
                })
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

                                axios.delete(this.endpoint)
                                    .then(res => {
                                        $(this.$el).fadeOut(500, () => {
                                            this.$toast.success(res.data.message, "Success", {timeout: 3000});
                                        })
                                    });

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        }, true],
                        ['<button>NO</button>', function (instance, toast) {

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        }],
                    ]
                });

            }
        },

        computed: { //This is equivalent to updated function in Livewire but this allows many methods to be defined
            isInvalid () {
                return this.body.length < 10; //this method will return true if body is less than 10
            },

            endpoint () {
                return `/questions/${this.questionId}/answers/${this.id}`;
            }
        }
    }
</script>

