<template>
    <div>
        <span class="text-muted"> {{ PostDate }}</span>
        <div class="media mt-2">
            <a :href="user.url" class="pr-2">
                <img :src="user.avatar">
            </a>
            <div class="media-body mt-1">
                <a :href="user.url">{{user.name}}</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        //name: "UserInfo",
        props: ['model', 'label'], //Required parameters to be supplied when called
        //<user-info model = "..." label=""></user-info>
        computed: {
            //Properties inside computed are cached and only recomputed when some
            //of its properties change
            PostDate () {
                return this.label + " " + this.model.created_date;
            }
        },
        data(){
            //Each component can have its own state and we define that
            //Inside this data method, we simply return an object in data method
            return {
                user: this.model.user
            }
        }

    }
</script>

<style scoped>

</style>
