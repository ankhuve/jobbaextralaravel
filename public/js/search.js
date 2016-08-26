(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
"use strict";

var toggledFilter = false;
var searchParameters;
var filterToggleArrow = $("#filterToggleArrow");
var spinner = '<div class="jobDescLoader"><div class="spinner-container container1"><div class="circle1"></div><div class="circle2"></div><div class="circle3"></div><div class="circle4"></div></div><div class="spinner-container container2"><div class="circle1"></div><div class="circle2"></div><div class="circle3"></div><div class="circle4"></div></div><div class="spinner-container container3"><div class="circle1"></div><div class="circle2"></div><div class="circle3"></div><div class="circle4"></div></div></div>';

var toggleFilters = function toggleFilters() {

    if (!toggledFilter) {
        $(".searchFilter").removeClass("searchFilterAnimation").hide();
        //setTimeout(function(){
        //    $(".searchFilter").hide(300);
        //}, 300);
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

var resetFilters = function resetFilters() {
    $(".defaultOption").attr('selected', 'selected');
    searchParameters = {};
};

var setSearchParameters = function setSearchParameters() {
    searchParameters = {
        q: $('#keyword').val(),
        yrkesomrade: $('#workArea').val(),
        lan: $('#county').val(),
        sida: 1
    };
};

$('#searchForm').submit(setSearchParameters());
//$('.enabled')

var paginate = function paginate(page) {
    if (typeof page == 'number' && searchParameters['sida'] + page > 0) {
        searchParameters['sida'] += page;
        getNewJobData();
    } else if (typeof page == 'string') {
        if (page === 'first' && searchParameters['sida'] != 1) {
            searchParameters['sida'] = 1;
            getNewJobData();
        } else if (page === 'last' && searchParameters['sida'] != Math.ceil($('#numberOfJobMatches').html() / 10)) {
            searchParameters['sida'] = Math.ceil($('#numberOfJobMatches').html() / 10);
            getNewJobData();
        }
    }
};

var enableOrDisablePaginateButtons = function enableOrDisablePaginateButtons() {
    var prevButtons = $('.prevButton');
    var nextButtons = $('.nextButton');
    if (getCurrentPage() === 1) {
        prevButtons.attr({ disabled: 'disabled' });
        nextButtons.removeAttr('disabled');
    } else if (getCurrentPage() === Math.ceil($('#numberOfJobMatches').html() / 10)) {
        nextButtons.attr({ disabled: 'disabled' });
        prevButtons.removeAttr('disabled');
    } else {
        prevButtons.removeAttr('disabled');
        nextButtons.removeAttr('disabled');
    }
};

var getCurrentPage = function getCurrentPage() {
    return searchParameters['page'];
};

var getNewJobData = function getNewJobData() {
    enableOrDisablePaginateButtons();
    setCurrentPage();
    $.ajax({
        url: '/search',
        type: 'get',
        data: searchParameters,
        success: function success(data) {
            data = JSON.parse(data);
            updateSearchResults(data);
        }
    });
};

var updateSearchResults = function updateSearchResults(data) {
    $('.jobBlock').remove();
    console.log(data);
    for (var i = 0; i < data.matchningdata.length; i++) {
        createNewJobPuff(data.matchningdata[i]);
    }
    getJobDescriptions();
};

var setCurrentPage = function setCurrentPage() {
    $('.viewingPageNumber').text('Sida ' + searchParameters['sida']);
};

var daysSincePublished = function daysSincePublished(publishedDate) {
    var today = new Date();
    var d = new Date(publishedDate);
    var dateDiffInDays = Math.floor((today - d) / (1000 * 60 * 60 * 24));
    if (dateDiffInDays < 1) {
        return 'Idag';
    } else if (dateDiffInDays === 1) {
        return 'Igår';
    } else {
        return dateDiffInDays + " dagar sedan";
    }
};

var createNewJobPuff = function createNewJobPuff(data) {
    $('.searchResults').html($('.searchResults').html() + '<div class="jobBlock col-md-6" id="' + data.annonsid + '">' + '<div class="upperInfo">' + '<a href="/job/' + data.annonsid + '">' + '<div class="titles">' + '<h1 class="text-left">' + data.annonsrubrik + '</h1>' + '<h2 class="text-right"><i>' + data.arbetsplatsnamn + '</i></h2>' + '</div>' + '</a>' + '<div class="jobShortDescription"></div>' + '</div>' + '<div class="bottomInfo">' + '<div class="col-md-4" title="Kommunen där jobbet finns.">' + '<img src="img/map_pin.png"/>' + '<span> ' + data.kommunnamn + ' </span>' + '</div>' + '<div class="col-md-4" title="Dagar sedan jobbet publicerades.">' + '<img src="img/time_ago.png"/>' + '<span>' + daysSincePublished(data.publiceraddatum) + '</span>' + '</div>' + '<div class="col-md-4" title="Sista ansökningsdatum för jobbet.">' + '<img src="img/calendar.png"/>' + '<span>' + data.publiceraddatum.substr(0, 10) + '</span>' + '</div>' + '</div>' + '</div>');
};

var getJobDescriptions = function getJobDescriptions() {
    var jobs = $('div.jobBlock');
    for (var i = 0; i < jobs.length; i++) {
        if (jobs[i].hasAttribute('id')) {
            (function (i) {
                $('#' + jobs[i].getAttribute('id')).find('.jobShortDescription').html(spinner);
                $.ajax({
                    url: 'getJobInfo/' + jobs[i].getAttribute('id'),
                    type: "get",
                    success: function success(data) {
                        var shortDescription;
                        if (data.length > 200) {
                            shortDescription = data.substring(0, 200) + " ...";
                        } else {
                            shortDescription = data;
                        }
                        $('#' + jobs[i].getAttribute('id')).find('.jobShortDescription').html(shortDescription);
                    }
                });
            })(i);
        }
    }
};

var toggleContactForm = function toggleContactForm() {
    $('#contactForm').show(300);
};

$(document).ready(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') }
    });
    getJobDescriptions();
    //enableOrDisablePaginateButtons();

    // confirm box when creating new job
    var toggled = false;
    var panel = $('#confirmBox');
    $('#openConfirmForm').click(function () {
        $(this).html('Stäng');
        $('.confirmationForm form').toggle(300);
        if (!toggled) {
            panel.css('width', '100%');
        } else {
            panel.css('width', '50%');
        }
        toggled = !toggled;
    });

    toggleFilters();

    if ($('#applicationValidationError').length) {
        $('#contactForm').show(300);
    }

    $('.filterButton.searchPage').on('click', toggleFilters);
    $('#resetFilters').on('click', resetFilters);

    $('.summernote').summernote({
        lang: 'sv-SE', // default: 'en-US'
        height: 300, // set editor height
        minHeight: null, // set minimum height of editor
        disableDragAndDrop: true,
        placeholder: 'Här beskriver du jobbets uppgifter, vad som förväntas av den jobbsökande, och kanske en kort företagsbeskrivning.',
        fontNames: ['Arial', 'Arial Black', 'Courier New', 'Helvetica', 'Impact', 'Roboto', 'Tahoma', 'Times New Roman', 'Verdana'],
        fontNamesIgnoreCheck: ['Roboto'],
        toolbar: [
        // [groupName, [list of button]]
        ['style', ['bold', 'italic', 'underline', 'clear']], ['fontsize', ['fontsize']], ['fontname', ['fontname']], ['color', ['color']], ['para', ['ul', 'ol', 'paragraph']], ['insert', ['link']], ['misc', ['undo', 'redo']]]
    });

    $('.modal').on('show.bs.modal', function () {
        var scrollTop = $(window).scrollTop();
        $(this).css({ 'top': scrollTop + 50 + 'px' });
    });

    $('[data-action]').on('click', function () {
        var action = $(this).data('action');
        if (action === "contactForm") {
            $('#contactForm').show(300);
        }
    });

    $('[data-dismiss]').on('click', function () {
        var action = $(this).data('dismiss');
        if (action === "contactForm") {
            $('#contactForm').hide(300);
        }
    });
});

},{}]},{},[1]);

//# sourceMappingURL=search.js.map
