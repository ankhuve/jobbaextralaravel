/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

// uncomment these for production
Vue.config.performance = false;
Vue.config.devtools = false;
Vue.config.debug = false;
Vue.config.silent = true;

// import components
Vue.component('job-counter', require('./components/JobCounter.vue'));
Vue.component('search-results', require('./components/SearchResults.vue'));
Vue.component('custom-job-puff', require('./components/CustomJobPuff.vue'));
Vue.component('job-puff', require('./components/JobPuff.vue'));

const app = new Vue({
    el: 'body',
    data:{
        applicationFormShowing: false
    },
    methods:{
        toggleApplicationForm: function(){
            this.applicationFormShowing = !this.applicationFormShowing;
        },

        resetSearchFilters: function(){
            $(".filters option[selected]").removeAttr('selected');
            $(".defaultOption").attr('selected','selected');
        }
    }
});

///////////////////////

var toggledFilter = false;
var filterToggleArrow = $("#filterToggleArrow");
const spinner = '<div class="jobDescLoader"><div class="spinner-container container1"><div class="circle1"></div><div class="circle2"></div><div class="circle3"></div><div class="circle4"></div></div><div class="spinner-container container2"><div class="circle1"></div><div class="circle2"></div><div class="circle3"></div><div class="circle4"></div></div><div class="spinner-container container3"><div class="circle1"></div><div class="circle2"></div><div class="circle3"></div><div class="circle4"></div></div></div>';

var toggleFilters = function() {

    if (!toggledFilter) {
        $(".searchFilter").removeClass("searchFilterAnimation").hide();
        $(".filters").removeClass("filtersAnimation");
        filterToggleArrow.removeClass("glyphicon-chevron-up");
        filterToggleArrow.addClass("glyphicon-chevron-down");
        $("#resetFilters").hide(300);
        toggledFilter = true;
    } else {
        $(".searchFilter").show().addClass("searchFilterAnimation");
        $(".filters").addClass("filtersAnimation");
        filterToggleArrow.removeClass("glyphicon-chevron-down");
        filterToggleArrow.addClass("glyphicon-chevron-up");
        $("#resetFilters").show(300);
        toggledFilter = false;
    }
};

var resetFilters = function(){
    $('.searchFilter').each(function () {
        $(this.children).each(function (el){
            $(this).removeAttr('selected');
        })
    });
    $(".defaultOption").attr('selected','selected');
};

$(document).ready(function () {
    toggleFilters();

    if($('#applicationValidationError').length){
        $('#contactForm').show(300);
    }

    $('.filterButton.searchPage').on('click', toggleFilters);
    $('#resetFilters').on('click', resetFilters);

    $('.modal').on('show.bs.modal', function () {
        var scrollTop = $(window).scrollTop();
        $(this).css({'top' : scrollTop + 50 +  'px'});
    });

    $('[data-action]').on('click', function () {
        var action = $(this).data('action');
        if(action === "contactForm"){
            $('#contactForm').show(300);
        }
    });

    $('[data-dismiss]').on('click', function () {
        var action = $(this).data('dismiss');
        if(action === "contactForm"){
            $('#contactForm').hide(300);
        }
    })

});