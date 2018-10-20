<template>
    <div>
        <button class="btn btn-link"
                @click="showCommentsFrom"
                v-text="text"
        >发送私信
        </button>
        <div class="modal fade" :id=dialog tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            评论列表
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div v-if="comments.length>0">
                            <div class="media" v-for="comment in comments">
                                <img width="24" class="mr-3" :src="comment.user.avatar">
                                <div class="media-body">
                                    <h5 class="mt-0">{{comment.user.name}}</h5>
                                    <p>{{comment.body}}<span class="float-right date">{{comment.created_at.substring(0,10)}}</span></p>

                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="text" class="form-control" v-model="body">
                        <button type="button" class="btn btn-primary" @click="store">评论</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['type', 'model', 'count'],
        data() {
            return {
                body: '',
                comments: [],
            }
        },
        computed: {
            dialog() {
                return 'comments-dialog-' + this.type + '-' + this.model
            },
            dialogId() {
                return '#' + this.dialog
            },
            text() {
                return this.count + '评论'
            }
        },
        methods: {
            store() {
                axios.post('/api/comment', {
                    'type': this.type,
                    'model': this.model,
                    'body': this.body
                }).then(response => {
                    let comment={
                        user:{
                            name:chuanqi.name,
                            avatar:chuanqi.avatar
                        },
                        body:response.data.body
                    }
                    this.comments.push(comment)
                    this.body = ''
                    this.count ++
                })
            },
            showCommentsFrom() {
                this.getComments()
                $(this.dialogId).modal('show')
            },
            getComments() {
                axios.get('/api/' + this.type + '/' + this.model + '/comments').then(response => {
                    this.comments = response.data
                })
            }

        }
    }
</script>
