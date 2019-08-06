"use strict";
function format(state) {
    if (!state.id) return state.text; 
    return "<img class='flag' src='../light/assets/img/flags/" + state.id.toLowerCase() + ".png'/> &nbsp;" + state.text;
}

var placeholder = "Select Options";
$('.select2, .select2-multiple').select2({
	theme: "bootstrap",
    placeholder: placeholder,
   templateSelection : function (tag, container){
            // here we are finding option element of tag and
        // if it has property 'locked' we will add class 'locked-tag' 
        // to be able to style element in select
        var $option = $('.select2-multiple option[value="'+tag.id+'"]');
        if ($option.attr('locked')){
           $(container).addClass('locked-tag');
           tag.locked = true; 
        }
        return tag.text;
     },
   })
   .on('select2:unselecting', function(e){
        // before removing tag we check option element of tag and 
      // if it has property 'locked' we will create error to prevent all select2 functionality
       if ($(e.params.args.data.element).attr('locked')) {
           e.preventDefault();
        }
     });
$("#selitemIcon").select2({
	theme: "bootstrap",
	templateResult: format,
    formatSelection: format,
    escapeMarkup: function(m) {
        return m;
    }
});
$('.select2-allow-clear').select2({
	theme: "bootstrap",
    allowClear: true,
    placeholder: placeholder
});
$( "button[data-select2-open]" ).click( function() {
	$( "#" + $( this ).data( "select2-open" ) ).select2( "open" );
});

$( ":checkbox" ).on( "click", function() {
	$( this ).parent().nextAll( "select" ).prop( "disabled", !this.checked );
});



