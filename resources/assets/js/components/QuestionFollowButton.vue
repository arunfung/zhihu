<template>
    <button class="btn btn-default"
            v-bind:class="{'btn-success': followed}"
            v-text="text"
            v-on:click="follow"
    >

    </button>
</template>
<style>
</style>
<script>
    export default{
        props:['question'],
        data(){
            return {
                followed: false
            }
        },
        mounted(){
          this.$http.post('/api/question/follower',{'question':this.question}).then(response => {
//              console.log(response.data);
              this.followed = response.data.followed;
          })
        },
        computed: {
            text() {
                return this.followed ? '已关注' : '关注问题'
            }
        },
        methods: {
            follow() {
                this.$http.post('/api/question/follow',{'question':this.question}).then(response => {
                    this.followed = response.data.followed;
                })
            }
        }
    }
</script>