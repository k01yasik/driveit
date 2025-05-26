<script>
    window.dashboardData = {
        posts: @json($posts ?? null),
        commentsVerified: @json($commentsVerified ?? null),
        commentsNotVerified: @json($commentsNotVerified ?? null)
    };
</script>
