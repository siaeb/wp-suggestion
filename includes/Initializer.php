<?php


namespace siaeb\suggestion\includes;


class Initializer {

    /**
     * Initializer constructor.
     */
    public function __construct() {
        // Autocomplete for "Add New Post" And "Edit Post" Page
        add_action('edit_form_before_permalink', [$this, 'display_search_results_wrapper']);
    }

    /**
     * Display search results wrapper
     *
     * @since 1.0
     * @access public
     * @return void
     */
    function display_search_results_wrapper() {
        ?>
        <style type="text/css">
            #ajax-search-results-wrapper {
                padding-right: 5px;
                border: 1px dashed lightblue;
                background-color: lightgoldenrodyellow;
            }
            #ajax-search-results-wrapper li a {
                text-decoration: none;
            }
        </style>
        <div id="ajax-search-results-wrapper" style="display: none;"></div>
        <div id="ajax-search-results-loading" style="color: red;font-weight: bold;display: none;" >لطفا منتظر بمانید ...</div>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                var searchLoading = $('#ajax-search-results-loading');
                var searchWrapper = $('#ajax-search-results-wrapper');
                // callback: The callback function
                // wait: The number of milliseconds to wait after the the last key press before firing the callback
                // highlight: Highlights the element when it receives focus
                // allowSubmit: Allows a non-multiline element to be submitted (enter key) regardless of captureLength
                // captureLength: Minimum # of characters necessary to fire the callback
                var options = {
                    callback: function (value) {
                        if (value.trim() == '') {
                            searchLoading.hide();
                            searchWrapper.hide();
                            return;
                        }
                        $.ajax({
                            url: ajaxurl,
                            type: 'GET',
                            data: {
                                action: 'spt-suggest-posts',
                                keyword: value,
                            },
                            dataType: 'json',
                            beforeSend: function() {
                                searchWrapper.hide();
                                searchLoading.slideDown('fast');
                            },
                            success: function(response) {
                                if (response.success) {
                                    searchWrapper.html(response.data).show();
                                } else {
                                    searchWrapper.hide();
                                }
                            },
                            complete: function() {
                                searchLoading.hide();
                            },
                        });
                    },
                    wait: 750,
                    highlight: true,
                    allowSubmit: false,
                    captureLength: 2
                }
            
                $("[name=post_title]").typeWatch( options );
            });
        </script>
        <?php
    }

}
