/*
Template Name: Minible - Responsive Bootstrap 4 Admin Dashboard
Author: Themesbrand
Version: 1.0.0
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Rating Js File
*/

$(document).ready(function () {

    // Default rating
    $('#example-rating').barrating({
        theme: 'fontawesome-stars',
        showSelectedRating: false
    });

    // CSS Stars
    $('#rating-css').barrating({
        theme: 'css-stars',
        showSelectedRating: false
    });


    // Current rating
    var currentRating = $('#rating-current-fontawesome-o').data('current-rating');

    $('.stars-example-fontawesome-o .current-rating')
        .find('span')
        .html(currentRating);

    $('.stars-example-fontawesome-o .clear-rating').on('click', function(event) {
        event.preventDefault();

        $('#rating-current-fontawesome-o')
            .barrating('clear');
    });

    $('#rating-current-fontawesome-o').barrating({
        theme: 'fontawesome-stars-o',
        showSelectedRating: false,
        initialRating: currentRating,
        onSelect: function(value, text) {
            if (!value) {
                $('#rating-current-fontawesome-o')
                    .barrating('clear');
            } else {
                $('.stars-example-fontawesome-o .current-rating')
                    .addClass('hidden');

                $('.stars-example-fontawesome-o .your-rating')
                    .removeClass('hidden')
                    .find('span')
                    .html(value);
            }
        },
        onClear: function(value, text) {
            $('.stars-example-fontawesome-o')
                .find('.current-rating')
                .removeClass('hidden')
                .end()
                .find('.your-rating')
                .addClass('hidden');
        }
    });


    // rating-1to10
    $('#rating-1to10').barrating('show', {
        theme: 'bars-1to10'
    });

    // rating-movie
    $('#rating-movie').barrating('show', {
        theme: 'bars-movie'
    });

    // rating square
    $('#rating-square').barrating('show', {
        theme: 'bars-square',
        showValues: true,
        showSelectedRating: false
    });

    // rating-pill
    $('#rating-pill').barrating('show', {
        theme: 'bars-pill',
        initialRating: 'A',
        showValues: true,
        showSelectedRating: false,
        allowEmpty: true,
        emptyValue: '-- no rating selected --',
        onSelect: function(value, text) {
            alert('Selected rating: ' + value);
        }
    });

    // rating-reversed
    $('#rating-reversed').barrating('show', {
        theme: 'bars-reversed',
        showSelectedRating: true,
        reverse: true
    });

    // rating-reversed
    $('#rating-horizontal').barrating('show', {
        theme: 'bars-horizontal',
        reverse: true,
        hoverState: false
    });
});