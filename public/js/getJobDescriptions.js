$(document).ready(function () {
    $.ajaxSetup({
        headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
    });
    var jobs = $('div.jobBlock');
    //var spinner = '<img src="img/loading_small.gif"/>';
    var spinner = '<div class="jobDescLoader"><div class="spinner-container container1"><div class="circle1"></div><div class="circle2"></div><div class="circle3"></div><div class="circle4"></div></div><div class="spinner-container container2"><div class="circle1"></div><div class="circle2"></div><div class="circle3"></div><div class="circle4"></div></div><div class="spinner-container container3"><div class="circle1"></div><div class="circle2"></div><div class="circle3"></div><div class="circle4"></div></div></div>'
    console.log(jobs);
    for (var i = 0; i < jobs.length; i++) {
        (function (i) {
            $('#' + jobs[i].getAttribute('id')).children('.upperInfo').children('.jobShortDescription').html(spinner);
            $.ajax({
                url: 'getJobInfo/' + jobs[i].getAttribute('id'),
                type: "get",
                success: function (data) {
                    var shortDescription;
                    if(data.length>250){
                        shortDescription = data.substring(0, 200)+" ...";
                    } else{
                        shortDescription = data;
                    }
                    $('#' + jobs[i].getAttribute('id')).children('.upperInfo').children('.jobShortDescription').html(shortDescription);
                }
            })
        })(i);
    }
});
