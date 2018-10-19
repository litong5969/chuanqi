<template>
    <button class="btn"
            v-bind:class="{'btn-secondary':followed,'btn-primary':!followed}"
            v-text="text"
            v-on:click="follow">
    </button>
</template>

<script>
    export default {

        props: ['article'],
        mounted() {
            axios.post('/api/article/follower', {'article': this.article}).then(response => {
                this.followed = response.data.followed
            })
        },
        data() {
            return {
                followed: false
            }
        },
        computed: {
            text() {
                return this.followed ? '已关注' : '关注该文'
            }
        },
        methods:{
            follow(){
                axios.post('/api/article/follow', {'article': this.article}).then(response => {
                    this.followed = response.data.followed
                })
            }
        }
    }
</script>
