<template>
    <button
            v-bind:class="{'btn-info':voted,'btn-vote':!voted}"
            v-text="text"
            v-on:click="vote"
    style="width: 60px">
        <i class="fa fa-magic" aria-hidden="true"></i>
    </button>
</template>

<script>
    export default {

        props: ['instalment', 'count'],
        mounted() {
            axios.post('/api/instalment/' + this.instalment + '/votes/users').then(response => {
                this.voted = response.data.voted
            })
        },
        data() {
            return {
                voted: false
            }
        },
        computed: {
            text() {
                return this.count
            },
            icon:  "fa fa-check-circle",
        },
        methods: {
            vote() {
                axios.post('/api/instalment/vote', {'instalment': this.instalment}).then(response => {
                    this.voted = response.data.voted
                    response.data.voted ? this.count++ : this.count--
                })
            }
        }
    }
</script>
