<template>
    <button class="btn btn-default"
            v-bind:class="{'btn-primary': voted}"
            v-text="text"
            v-on:click="vote"
    >

    </button>
</template>
<style>
</style>
<script>
    export default{
        props:['answer','count'],
        data(){
            return {
                voted: false,
                counts: this.count
            }
        },
        mounted(){
            this.$http.post('/api/answer/'+this.answer+'/votes/users').then(response => {
                this.voted = response.data.voted;
            })
        },
        computed: {
            text() {
                return this.counts
            }
        },
        methods: {
            vote() {
                this.$http.post('/api/answer/vote',{'answer':this.answer}).then(response => {
                    this.voted = response.data.voted;
                    response.data.voted ? this.counts ++ : this.counts --;
                })
            }
        }
    }
</script>