/**
 * Created by thomaswalsh on 4/15/16.
 */

$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $('.add-env').click(function(){
        var environment = $(this).closest('.input-group').find('.env-name').val();
        var parent = $(this).data('parent');
        var url = '/environment';
        if(parent > 0)
            url += '/'+parent;

        $.post(url, {
            name: environment
        }, function(data){
            if(data.success){
                window.location = '/environment/'+data.id;
            }
            else{
                alert(data.error);
            }
        });
    });
    $('#export').click(function(){

    });
    $('.del-value').click(function(){
        var val_id = $(this).data('id');
        var env_id = $(this).data('env');
        var current_html = $(this).closest('tr');
        $.post('/delete-variable',{
            id: val_id,
            environment: env_id
        }, function(data){
            if(data.success){
                if(data.parent_html){
                    current_html.replaceWith(data.parent_html);
                }
                else{
                    current_html.remove();
                }
            }
        });
    });
    $('#add-env').click(function(){
        var errors =$('#add-error');
        errors.slideUp('fast');
        var env_id = $(this).data('id');
        var name = $('#add-env-name').val();
        var value = $('#add-env-value').val();
        if($('input[data-name='+name+']').length > 0){
            errors.text("This variable already exists!").slideDown('fast');

        }
        else{
            $.post('/set-variable/'+env_id, {
                name: name,
                value: value
            }, function(data){
                if(data.success){

                    $('.table').find('tbody').append(data.html);
                }
            });
        }
    });
    $('.var-value').blur(function(){
        var current_html = $(this).closest('tr');
        var env_id = $(this).data('env');
        var name = $(this).data('name');
        var value = $(this).val();

        $.post('/set-variable/'+env_id, {
            name: name,
            value: value
        }, function(data){
            if(data.success){
                current_html.replaceWith(data.html);
            }
        });
    });

});
