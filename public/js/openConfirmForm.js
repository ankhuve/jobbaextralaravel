$(document).ready(function () {
    var toggled = false;
    var panel = $('#confirmBox');
    $('#openConfirmForm').click(function () {
        $(this).html('Stäng');
        $('.confirmationForm form').toggle(300);
        if(!toggled){
            panel.css('width', '100%');
        } else{
            panel.css('width', '50%');
        }
        toggled = !toggled;

    });
});
