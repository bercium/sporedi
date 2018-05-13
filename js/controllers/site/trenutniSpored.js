$('.cat-select').change(function() {
    var search = $(this).val().toLowerCase();
    gase("current_filter-category_"+search);
    $('.show-item').each(function(i, el) {
        var text = $(el).attr('alt-cat');
        if (text.toLowerCase().indexOf(search) == -1 && search.length > 0) $(el).hide();
        else $(el).show();
        
    });
});