<script>
    let posts = {!! json_encode($posts, JSON_HEX_TAG) !!};
    let commentsVerified = {!! $commentsVerified !!};
    let commentsNotVerified = {!! $commentsNotVerified !!};
</script>
