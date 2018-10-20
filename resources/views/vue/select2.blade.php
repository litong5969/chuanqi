<script type="text/javascript">
    // select2内容
    $(document).ready(function () {
        function formatTag(tag) {
            return "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" +
            tag.name ? tag.name : "Laravel" +
                "</div></div></div>";
        }

        function formatTagSelection(tag) {
            return tag.name || tag.text;
        }

        $(".js-example-placeholder-multiple").select2({
            tags: true,
            placeholder: '选择相关话题',
            minimumInputLength: 2,
            ajax: {
                url: '/api/tags',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {q: params.term};
                },
                processResults: function (data, params) {
                    return {results: data};
                },
                cache: true
            },

            templateResult: formatTag,
            templateSelection: formatTagSelection,
            escapeMarkup: function (markup) {
                return markup;
            }

        });

    });
</script>