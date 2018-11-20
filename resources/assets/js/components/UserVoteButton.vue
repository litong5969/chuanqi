<template>
    <div>
        <button
                class="btn btn-link "
                style="color:#0a001f;"
                v-text="text"
                v-on:click="vote">
        </button>
    </div>
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
                if(this.voted){
                    return this.count +' 已赞'
                }else{
                    return this.count +' 赞'
                }

            },
        },
        methods: {
            vote() {
                axios.post('/api/instalment/vote', {'instalment': this.instalment}).then(response => {
                    this.voted = response.data.voted;
                    response.data.voted ? this.count++ : this.count--
                })
            }
        }
    }
</script>
