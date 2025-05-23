<script>
    let posts = {!! json_encode($posts, JSON_HEX_TAG) !!};
    let commentsVerified = {!! $commentsVerified !!};
    let commentsNotVerified = {!! $commentsNotVerified !!};
    /* let datesQuery = {!! json_encode($datesQuery, JSON_HEX_TAG) !!};
    let usersQuery = {!! json_encode($usersQuery, JSON_HEX_TAG) !!};
    let sessionQuery = {!! json_encode($sessionQuery, JSON_HEX_TAG) !!};
    let hitsQuery = {!! json_encode($hitsQuery, JSON_HEX_TAG) !!};
    let countryQueryLabels = {!! json_encode($countryQueryLabels, JSON_HEX_TAG) !!};
    let countryQueryData = {!! json_encode($countryQueryData, JSON_HEX_TAG) !!};
    let cityQueryLabels = {!! json_encode($cityQueryLabels, JSON_HEX_TAG) !!};
    let cityQueryData = {!! json_encode($cityQueryData, JSON_HEX_TAG) !!}
    */
</script>
