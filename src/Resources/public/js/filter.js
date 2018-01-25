(function(e) {

    /*
        Immediately Invoked Function Expression
        http://gregfranko.com/jquery-best-practices/
    */
    e(window.jQuery, window, document);

}(function($, window, document) {

    // The $ is now locally scoped

    function filterTeasers() {
        var filterSelect = $('.mod_teaserfilter select'),
            filterValue = filterSelect.val(),
            teaserElems = $('.ce_teaserlist .teaser');

        if (filterValue == '') {
            teaserElems.fadeIn(450);
        } else {
            var filteredTeaserElem = teaserElems.filter('.' + filterValue);

            filteredTeaserElem.fadeIn(450);
            teaserElems.not(filteredTeaserElem).hide();
        }
    }

    // Listen for the jQuery ready event on the document
    $(function() {

        // The DOM is ready!

        if($('.mod_teaserfilter').length) {
            filterTeasers();
        }

        /*
            Filter teaser elements
        */
        $('.mod_teaserfilter select').on('change', function() {
            filterTeasers();
        });
    });
}));