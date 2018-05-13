$(document).ready(function() {

    // page is now ready, initialize the calendar...


    $('#calendar').fullCalendar({
        defaultView:'month',
        header: {
            left: 'prev',
            center: 'today',
            right: 'next'
        },
        editable: false,
        minTime:7,
        maxTime:22,
        timeFormat: {
          // for agendaWeek and agendaDay
          agendaWeek: 'H:mm{ - H:mm}', // 5:00 - 6:30
          agendaDay: 'H:mm{ - H:mm}', // 5:00 - 6:30
          // for all other views
          '': 'H:mm'
        },
        events: events,
        axisFormat: 'HH:mm',
        columnFormat:{
          month:"ddd",
          agendaWeek: "ddd d.M.",
          agendaDay: "ddd d.M."
        },
        eventColor: '#008cba',
        firstDay:1,
        loading: function(bool) {
              if (bool) $('.loading').show();
              else $('.loading').hide();
        },
        eventAfterRender: function(event, element, view) {
          $('.loading').hide();
          //$(element).attr('title',event.title);
          $(element).attr('data-dropdown','drop-cal-info');
          $(element).click(function(){
            $('#drop-cal-info-title').html(event.pure_title);
            var subtitle = '';
            if (event.season) subtitle = subtitle + event.season + ' .sezona ';
            if (event.episode) subtitle = subtitle + event.episode + ' .del ';
            $('#drop-cal-info-subtitle').html('<em>'+subtitle+'</em>');
            $('#drop-cal-info-channel').html(event.channel);
            $('#drop-cal-info-channelicon').attr('src',$('#drop-cal-info-channelicon').attr('path')+event.channelslug+'.png');
            $('#drop-cal-info-description').html(event.description);
            
            //$('#drop-cal-info-content').html(event.content);
            //$('#drop-cal-info-link').attr('href',event.link);

            if (event.showslug == ''){
                $('#drop-cal-info-link').hide();
                $('#drop-cal-info-link-info').show();
            }
            else{
                $('#drop-cal-info-link').show();
                $('#drop-cal-info-link-info').hide();
            }
            
            console.log($('#drop-cal-info-link').attr('path')+'/'+event.showslug+'/'+event.id+'/oddaja');
            $('#drop-cal-info-link').attr('href',$('#drop-cal-info-link').attr('path')+'/'+event.showslug+'/'+event.id+'/oddaja');
            
            gase("calendar_info-show_"+event.showslug);

          });
        }
    });
    
     $(document).foundation();

});