$().ready(function() {
    $('.test-airlock').click(function() {        
        axios.get('/api/user').then(response => {
            console.log(response);
        }).catch(function(error) {
            console.log("Unauthorized");
        });        
    });
});