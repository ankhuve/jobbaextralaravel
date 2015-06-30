var toggledFilter = false;
var toggleFilters = function() {

    if (toggledFilter) {
        $(".searchFilter").removeClass("searchFilterAnimation");
        $(".filters").removeClass("filtersAnimation");
        $("#filterToggleArrow").removeClass("glyphicon-chevron-up");
        $("#filterToggleArrow").addClass("glyphicon-chevron-down");
        $("#resetFilters").hide(300);
        toggledFilter = false;
    } else {
        $(".searchFilter").addClass("searchFilterAnimation");
        $(".filters").addClass("filtersAnimation");
        $("#filterToggleArrow").removeClass("glyphicon-chevron-down");
        $("#filterToggleArrow").addClass("glyphicon-chevron-up");
        $("#resetFilters").show(300);
        toggledFilter = true;
    }
};

var resetFilters = function(){
    $(".defaultOption").attr('selected','selected');
}