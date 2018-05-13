
(function($, window, undefined) {
    $(document).foundation();
    if (typeof is_debug !== 'undefined') {
        $("a:not([trk])").each(function() {
            console.log("No tracking for link: " + $(this).attr("href"));
        });
    }
    $("[trk]").each(function() {
        var trk_id = $(this).attr("trk");
        $(this).click(function(event) {
            gase(trk_id);
        });
    });
    h = $(window).height() - ($('.footer').offset().top);
    if (h > 0) {
        $('.footer').css('margin-top', h + 9);
    }
    $('.offscreen-right').click(function() {
        $('.animate-sidebar').addClass('hide-for-small');
        $('.animate-content').show();
    });
    $('.offscreen-left').click(function() {
        $('.animate-sidebar').removeClass('hide-for-small');
        $('.animate-content').hide();
    });
    if (!$('.offscreen-arrow-right').length) {
        $('.offscreen-left').remove();
        $('.offscreen-right').remove();
    }
    $('.header_search_frm').submit(function(e) {
        var link = $(this).attr('action');
        $(this).attr('action', link + '?q=' + ($('.header_search_edt').val()));
    });
    if ($('.past-show').length > 3) {
        $('.past-show').hide().last().show();
        $('.past-show-filler').show();
        h = $(window).height() - ($('.footer').offset().top);
        if (h > 0) {
            $('.footer').css('margin-top', h + 9);
        }
    }
    setTimeout(function() {
        switchPlaceholder(0);
    }, 4000);
    $('.channel_filter').keyup(function() {
        $('.channel_list a').each(function(i, el) {
            var text = $(el).text();
            var search = $('.channel_filter').val().toLowerCase();
            if (text.toLowerCase().indexOf(search) == -1 && search.length > 0) {
                $(el).hide();
            } else {
                $(el).show();
            }
        });
        $('.show-item').each(function(i, el) {
            var text = $(el).attr('alt-ch');
            var search = $('.channel_filter').val().toLowerCase();
            if (text.toLowerCase().indexOf(search) == -1 && search.length > 0) {
                $(el).hide();
            } else {
                $(el).show();
            }
        });
    });
})(jQuery, this);
$(document).ready(function() {
    if (typeof Cookies !== 'undefined'){
        var favs = Cookies.getJSON('favs');
        if (favs !== undefined) {
            for (var prop in favs) {
                if (favs[prop] == 1) $('[ch="' + prop + '"]').removeClass('heart').addClass('heart-active');
            }
        }
        $('.channel-fav').click(function() {
            if ($(this).hasClass('heart')) {
                $(this).removeClass('heart').addClass('heart-active');
                setFav($(this).attr('ch'), 1);
            } else {
                $(this).removeClass('heart-active').addClass('heart');
                setFav($(this).attr('ch'), 0);
            }
        });
    }
});

function switchPlaceholder(i) {
    hints = ['prijatelji 1. sezona', 'jutri film ocena 8.5', 'trenutno nanizanka 5. del', 'kriminalka petek', 'risanka jutri zjutraj'];
    $('.header_search_edt').attr('placeholder', hints[i]);
    i = ((i + 1) % (hints.length));
    setTimeout(function() {
        switchPlaceholder(i);
    }, 4000);
}

function contact(e) {
    var pri = "@";
    e.href = "mailto:info";
    e.href += pri + "sporedi.net";
    $(e).html('info' + pri + 'sporedi.net');
}

function splitComa(val) {
    return val.split(/,\s*/);
}

function extractLast(term) {
    return splitComa(term).pop();
}

function gase(id) {
    if (typeof is_debug !== 'undefined') {
        console.log("Tracking click: " + id);
    }
    var trk = id.split("_");
    if (trk[0] == 'social') {
        if (trk.length > 2) ga('send', 'social', trk[1], trk[2], window.location.pathname);
        if (trk.length > 3) ga('send', 'event', trk[2], trk[1], trk[3], 1);
    } else {
        if (trk.length > 3) ga('send', 'event', trk[0], trk[1], trk[2], trk[3]);
        else
        if (trk.length > 2) ga('send', 'event', trk[0], trk[1], trk[2]);
        else
        if (trk.length > 1) ga('send', 'event', trk[0], trk[1]);
    }
}

function stopPropagation(inEvent) {
    if (inEvent == null) return;
    inEvent.cancelBubble = true;
    if (inEvent.stopPropagation) inEvent.stopPropagation();
}

function setFav(channel, active) {
    var favs = Cookies.getJSON('favs');
    if (favs === undefined) favs = new Object();
    favs[channel] = active;
    Cookies.set('favs', favs, {
        expires: 365
    });
}

setTimeout(function () { ga('send', 'event', { eventCategory: 'Reading', eventAction: 'Viewed 5 Seconds+', eventLabel: 'Page: '+ location.pathname.toLowerCase() }); }, 5000);
setTimeout(function () { ga('send', 'event', { eventCategory: 'Reading', eventAction: 'Viewed 15 Seconds+', eventLabel: 'Page: '+ location.pathname.toLowerCase() }); }, 15000);