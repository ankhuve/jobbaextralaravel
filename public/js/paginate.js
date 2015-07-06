

paginate = function(page) {
    $.ajaxSetup({
        headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
    });
    console.log(page);
    $.ajax({
        url: '/search',
        type: 'get',
        sida: page,
        success: function (data) {
            console.log(data);
        }
    })
}