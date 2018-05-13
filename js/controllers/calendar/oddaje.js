
$('.add-to-list').click(function(){
    fav_shows = fav_shows.replace(new RegExp('\\|'+$(this).attr('rel-id')+'\\|', 'g'),'');
    if ($(this).hasClass('warning')){
        $(this).removeClass('warning').addClass('success').html('Dodaj na seznam');
    }else{
        $(this).addClass('warning').removeClass('success').html('Odstrani iz seznama');
        fav_shows = fav_shows + '|'+$(this).attr('rel-id')+'|';
    }
    Cookies.set('fav_shows', fav_shows, { expires: 7 });
});