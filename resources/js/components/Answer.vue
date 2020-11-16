
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
                axios.patch(`/questions/${this.questionId}/answers/${this.id}`, {
                    body: this.body
                })
                    .then(res => {
                        console.log(res);
                        this.editing = false;
                        this.bodyHtml = res.data.body_html;
                        alert(res.data.message);
                    }) // If ajax call is successful
                    .catch( err => {
                        alert(err.response.data.message);
                    }); // If ajax call is fails
            }
        },

        computed: { //This is equivalent to updated function in Livewire but this allows many methods to be defined
            isInvalid () {
                return this.body.length < 10; //this method will return true if body is less than 10
            }
        }
    }
</script>

