<template>
    <div class="d-flex flex-column vote-controls">
        <a @click.prevent="voteUp" :title="title('up')"
           class="vote-up" :class="classes">
            <i class="fas fa-caret-up fa-3x"></i>
        </a>

        <span class="votes-count">{{count}}</span>
        <a @click.prevent="voteDown" :title="title('down')" class="vote-down" :class="classes">
            <i class="fas fa-caret-down fa-3x"></i>
        </a>

        <Favorite v-if="name === 'question'" :question="model"></Favorite>
        <accept v-else :answer="model"></accept>

    </div>

</template>

<script>
    import Favorite from "./Favorite";
    import Accept from "./Accept";

    export default {
        props: ['name', 'model'],

        computed: {
            classes () {
                return this.signedIn ? '' : 'off';
            },

            endpoint () {
                //We make the ajax endpoint dynamic for both vote answers and vote questions
                return `/${this.name}s/${this.id}/vote `
            }

        },

        //Registering the imported component
        components: {
            Favorite: Favorite,
            Accept: Accept,
        },

        data () {
            return {
                count: this.model.votes_count || 0,
                id: this.model.id,
            }
        },

        methods: {
            title (voteType) {
                let titles = {
                    up: `This ${this.name} is useful`,
                    down: `This ${this.name} is not useful`
                };
                return titles[voteType];
            },
            voteUp () {
                this._vote(1);
            },

            voteDown () {
                this._vote(-1)
            },

            _vote(vote) {
                if(!this.signedIn) { //if user is not signed in, they are not eligible to vote
                    this.$toast.warning(`Please login to vote the ${this.name}`, "Warning", {
                        timeout: 3000,
                        position: 'bottomLeft'
                    });
                    return;
                }
                axios.post(this.endpoint, { vote })
                .then(res => {
                   this.$toast.success(res.data.message, "Success", {
                     timeout: 3000,
                     position: 'bottomLeft'
                   });
                   this.count = res.data.voteCount;
                });
            }
        }



    }
</script>

