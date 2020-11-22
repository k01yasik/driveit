$('.test-airlock').click(function() {
    axios.get('/api/user').then(response => {
        console.log(response.data.slug);
    }).catch(function(error) {
        console.log("Unauthorized");
    });
});