<script type="text/javascript">
var ue = UE.getEditor('container', {
toolbars: [
['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft', 'justifycenter', 'justifyright', 'link', 'insertimage', 'fullscreen']
],
autoHeightEnabled: true,
elementPathEnabled: false,
enableContextMenu: false,
autoClearEmptyNode: true,
initialFrameHeight:220,
wordCount: true,
maximumWords:10000,
minFrameHeight:140,
imagePopup: false,
autotypeset: {indent: true, imageBlockLine: 'center'},
});
ue.ready(function () {
ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
});
</script>