<template>
    <div>
        <button class="btn btn-outline-secondary"
                @click="showSendMessageFrom">
            发送私信
        </button>
        <div class="modal fade" id="modal-send-message" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            发送私信
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <textarea name="body" class="form-control" rows="5" v-model="body" v-if="!status"></textarea>
                        <div class="alert alert-success" role="alert" v-if="status">
                            <strong><h6 class="text-center">私信发送成功</h6></strong>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="store">发送私信</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        props: ['user'],
        data() {
            return {
                body: '',
                status: false
            }
        },
        methods: {
            store() {
                axios.post('/api/message/store', {'user': this.user, 'body': this.body}).then(response => {
                    this.status = response.data.status;

                    setTimeout(function () {
                        $('#modal-send-message').modal('hide')
                    },2000)


                })
            },
            showSendMessageFrom() {
                $('#modal-send-message').modal('show');
                this.body='';
                this.status=false
            }

        }
    }
</script>
