jQuery(document).ready(function() {
    $bsfb_button_stateful_len = jQuery('.bsfb-button-stateful').length;
    if($bsfb_button_stateful_len>0) {
        setInterval( function() {
            jQuery('.bsfb-button-stateful').button('reset')
        }, 2000);
        jQuery('.bsfb-button-stateful').live('click', function() {
            jQuery(this).button('loading');
        });
    }
    jQuery('.bsfb-tooltip').tooltip('hide')
});