jQuery(document).ready(function($){
 
    var custom_uploader_iphone;
    var custom_uploader_iphone_retina;
    var custom_uploader_ipad;
    var custom_uploader_ipad_retina;
 
    $('#appti_upload_iphone_icon').click(function(e) {
 
        e.preventDefault();
 
        // Si el objeto Uploader ya ha sido creado, reabrimos el cuadro de dialogo.
        if (custom_uploader_iphone) {
            custom_uploader_iphone.open();
            return;
        }
 
        // Extendemos del objeto wp.media
        custom_uploader_iphone = wp.media.frames.file_frame = wp.media({
            multiple: false
        });
 
        // Cuando añadimos un archivo, se atrapa la URL y se manda al campo de texto #upload_image.
        custom_uploader_iphone.on('select', function() {
            attachment = custom_uploader_iphone.state().get('selection').first().toJSON();
            $('#appti_iphone_icon').val(attachment.url);
        });
 
        // Abre el cuadro de dialogo
        custom_uploader_iphone.open();
 
    });
    
    $('#appti_upload_ipad_icon').click(function(e) {
 
        e.preventDefault();
 
        // Si el objeto Uploader ya ha sido creado, reabrimos el cuadro de dialogo.
        if (custom_uploader_ipad) {
            custom_uploader_ipad.open();
            return;
        }
 
        // Extendemos del objeto wp.media
        custom_uploader_ipad = wp.media.frames.file_frame = wp.media({
            multiple: false
        });
 
        // Cuando añadimos un archivo, se atrapa la URL y se manda al campo de texto #upload_image.
        custom_uploader_ipad.on('select', function() {
            attachment = custom_uploader_ipad.state().get('selection').first().toJSON();
            $('#appti_ipad_icon').val(attachment.url);
        });
 
        // Abre el cuadro de dialogo
        custom_uploader_ipad.open();
 
    });
    
    $('#appti_upload_iphone_retina_icon').click(function(e) {
 
        e.preventDefault();
 
        // Si el objeto Uploader ya ha sido creado, reabrimos el cuadro de dialogo.
        if (custom_uploader_iphone_retina) {
            custom_uploader_iphone_retina.open();
            return;
        }
 
        // Extendemos del objeto wp.media
        custom_uploader_iphone_retina = wp.media.frames.file_frame = wp.media({
            multiple: false
        });
 
        // Cuando añadimos un archivo, se atrapa la URL y se manda al campo de texto #upload_image.
        custom_uploader_iphone_retina.on('select', function() {
            attachment = custom_uploader_iphone_retina.state().get('selection').first().toJSON();
            $('#appti_iphone_retina_icon').val(attachment.url);
        });
 
        // Abre el cuadro de dialogo
        custom_uploader_iphone_retina.open();
 
    });
    
    $('#appti_upload_ipad_retina_icon').click(function(e) {
 
        e.preventDefault();
 
        // Si el objeto Uploader ya ha sido creado, reabrimos el cuadro de dialogo.
        if (custom_uploader_ipad_retina) {
            custom_uploader_ipad_retina.open();
            return;
        }
 
        // Extendemos del objeto wp.media
        custom_uploader_ipad_retina = wp.media.frames.file_frame = wp.media({
            multiple: false
        });
 
        // Cuando añadimos un archivo, se atrapa la URL y se manda al campo de texto #upload_image.
        custom_uploader_ipad_retina.on('select', function() {
            attachment = custom_uploader_ipad_retina.state().get('selection').first().toJSON();
            $('#appti_ipad_retina_icon').val(attachment.url);
        });
 
        // Abre el cuadro de dialogo
        custom_uploader_ipad_retina.open();
 
    });            
 
});