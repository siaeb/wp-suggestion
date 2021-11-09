jQuery(document).ready(function ($) {
    $( "#tag-name" ).autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: ajaxurl,
                dataType: "json",
                data: {
                    action: "spt-suggest-terms",
                    term  : request.term,
                    taxonomy: spt_params.taxonomy,
                    _wpnonce: spt_params.nonce,
                },
                success: function( result ) {
                    response( $.map(result.data, function(item) {
                        return {
                            value: item.name,
                            label: item.name,
                        };
                    }) );
                }
            });
        },
        minLength: 2,
    });

    $( "[name=post_title]" ).autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: ajaxurl,
                type: 'GET',
                dataType: "json",
                data: {
                    action  : 'spt-suggest-posts',
                    keyword : request.term,
                    _wpnonce: spt_params.nonce,
                },
                success: function( result ) {
                    response( $.map(result.data, function(item) {
                        return {
                            value: item.name,
                            label: item.name,
                        };
                    }) );
                }
            });
        },
        minLength: 2,
    });
});
