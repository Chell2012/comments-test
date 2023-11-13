

$(document).ready(function(){
    
    function toggleMenu() {
        var menuItems = document.getElementsByClassName('menu-item');
        for (var i = 0; i < menuItems.length; i++) {
            var menuItem = menuItems[i];
            menuItem.classList.toggle("hidden");
        }
    }
    
    function buildComment(comment){
        var email = $('<p>', {
            text: comment.id + ". " + comment.email
        });
        var text = $('<p>', {
            text: comment.text
        });
        var time = $('<p>', {
            text: comment.created_at
        });
        var button = $('<button>',{
            type: 'submit',
            class: 'btn btn-danger',
            text: 'Delete'
        });
        var form = $('<form>',{
            class: "delete-form",
            action: "comment/"+comment.id,
            method: 'DELETE'
        }).append(button);
        var leftBlock = $('<div>', {
            'class': 'col-lg-9'
        }).append(email).append(text);
        var rightBlock = $('<div>', {
            'class': 'col-lg-3'
        }).append(time).append(form);
        var row = $('<div>', {
            'class': 'row mb-3 border-top'
        }).append(leftBlock).append(rightBlock);
        $('#comments-block').append(row);
    }
    
    function buildCommentsList(comments){
        $('#comments-block').empty();
        comments.forEach(function (item){
            buildComment(item);
        });
    }
    
    function addErrorsToField(errors){
        $('#errors-field').attr('hidden',true);
        $('#errors-list').empty();
        if (errors) {
            $('#errors-field').removeAttr('hidden');
            if (Array.isArray(errors))
                errors.forEach(function(error){
                    var text = $('<p>', {
                        text: error.text
                    });
                    var element = $('<li>').append(text);
                    $('#errors-list').append(element);
                });
            else {
                var text = $('<p>', {
                    text: errors.text
                });
                var element = $('<li>').append(text);
                $('#errors-list').append(element);
            }
            errors = null;    
        }
    }
    
    $('#comment').submit(function( event ){
        event.preventDefault();

        var csrfName = $('#csrf').attr('name');
        var csrfHash = $('#csrf').val();
        var formData = {
            text: $("#text").val(),
            email: $("#email").val(),
            [csrfName]: csrfHash
        };

        $.ajax({
        url: "/comment",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function(response){
                $('#csrf').val(response.csrf_token);
                    console.log(response.csrf_token);
                if (response.success == 1){
                    $('#text,#email').val('');
                    updateCommentsList();
                    addErrorsToField(response.errors);
                }else {
                    addErrorsToField(response.errors);
                }
            }
        });
    });
    $(document).on('submit', '.delete-form', function(event){
        event.preventDefault();
        
        var csrfName = $('#csrf').attr('name');
        var csrfHash = $('#csrf').val();
        var action = $(this).attr("action");
        
        $.ajax({
            url: action,
            method: "DELETE",
            dataType: 'json',
            success: function(response) {
                $('#csrf').val(response.csrf_token);
                updateCommentsList();
            }
        });
    });
    
    function updateCommentsList(){
        var page = GetParameterValues("page");
        var order = GetParameterValues("order");
        var formData = {
            page: page,
            order: order,
            json: 1,
        };
        $.ajax({
            url:'/',
            method: 'get',
            data: formData,
            success: function(response) {
                if (typeof response.comments  !== "undefined"){
                    buildCommentsList(response.comments.comments);
                } 
            }
        });
    }
    
    function GetParameterValues(param) {
        var url = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for (var i = 0; i < url.length; i++) {
            var urlparam = url[i].split('=');
            if (urlparam[0] == param) {
                return urlparam[1];
            }
        }
    }
});