<script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "Article",
        "author": "{{ $username }}",
        "name": "{{ $postname }}",
        "description": "{{ $description }}",
        "image": "{{ $image }}",
        "url": "{{url('/')}}/posts/{{ $slug }}",
        "headline": "{{ $postname }}",
        "datePublished": "{{ $updated }}",
        "dateModified": "{{ $updated }}"
    }
</script>