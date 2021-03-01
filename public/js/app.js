var app = (function($){

    var token;
    var is_active = 0;

    function init(){
        token = localStorage.getItem('_token');
        if (!token) {
            window.location.href = '/auth/login';
        }

        return this;
    }

    function login(){
        
        $('#btn-continue').on('click', function(evt){
            console.log('dfd');
            var form_data = {
                email: $('#email').val(),
                password: $('#password').val(),
            };
            sendAjax(form_data, "POST");

            evt.preventDefault();
        });

        return this;
    }

    function loadAnnouncements(url){
        $.ajax({
            url: url,
            method: "GET",
            beforeSend: function (xhr) {
                xhr.setRequestHeader ("Authorization", "Bearer " + token);
            },
            success: function(response, status, request){
                var items = '';
                var data =  response.data;
                
                for(var i = 0; i < data.length; i++){
                    var state = data[i].active == 1 ? '<span class="text-success">Active</span>' : '<span class="text-default">Inactive</span>';
                    items += "<tr>";
                        items += "<td>" + data[i].title + "</td>";
                        items += "<td>" + data[i].content + "</td>";
                        items += "<td>" + data[i].start_date + "</td>";
                        items += "<td>" + data[i].end_date + "</td>";
                        items += "<td>" + state + "</td>";
                        items += "<td>";
                            items += '<a href="javascript:void(0);" data-toggle="modal" data-target="#addFormModal" data-id="' + data[i].id + '" data-title="' + data[i].title + '" data-content="' + data[i].content + '" data-start-date="' + data[i].start_date + '" data-end-date="' + data[i].end_date + '" data-active="' + data[i].active + '" class="ax-edit">Edit</a>&nbsp;&nbsp;';
                            items += '<a href="javascript:void(0);" data-id="' + data[i].id + '" class="ax-delete">Delete</a>';
                        items += "</td>";
                    items += "</tr>";
                }
                $('#table-body').html(items);
            },
            error: function(xhr, status, thrown){
                console.log(xhr);
                // token expired
                window.location.href = '/auth/login';
            }
        });
        return this;
    }

    function events(){
        $('#table-body').on('click', '.ax-edit', function(evt){
            var me = $(this);
            var form_data = {
                id: me.attr('data-id'),
                title: me.attr('data-title'),
                content: me.attr('data-content'),
                start_date: me.attr('data-start-date'),
                end_date: me.attr('data-end-date'),
                status: me.attr('data-active'),
            };
            $('#title').val(form_data.title);
            $('#content').val(form_data.content);
            $('#start_date').val(form_data.start_date);
            $('#end_date').val(form_data.end_date);
            is_active = 0;
            if (form_data.status == 1) {
                is_active = 1;
                $('#active').prop('checked', true);
            }

            $('body').data('id', form_data.id);

            

        });

        $('#active').on('click', function(evt){
            
            if ($(this).is(':checked')) {
                is_active = 1;
            } else {
                is_active = 0;
            }
            console.log(is_active);
        });

        $('#btn-save').on('click', function(evt){
            evt.preventDefault();
           
            var form_data = {
                title: $('#title').val(),
                content: $('#content').val(),
                start_date: $('#start_date').val(),
                end_date: $('#end_date').val(),
                status: is_active,
            };

            if ($('body').data('id')) {
                form_data.id = $('body').data('id');
            }

            saveAnnouncement("POST", form_data);
        });

        $('#table-body').on('click', '.ax-delete', function(evt){
            evt.preventDefault();
            var id = $(this).attr('data-id');
            $.ajax({
                url: '/api/user/announcement/' + id,
                method: 'DELETE',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader ("Authorization", "Bearer " + token);
                },
                success: function(response, status, request){
                    window.location.href = window.location.href;
                },
                error: function(xhr, status, thrown){
                    console.log(xhr);
                }
            });
        });
    }

    function saveAnnouncement(method, formData){
        
        $.ajax({
            url: window.post_announcement_url,
            method: method,
            data: formData,
            beforeSend: function (xhr) {
                xhr.setRequestHeader ("Authorization", "Bearer " + token);
            },
            success: function(response, status, request){
                $('body').removeData('id');
                window.location.href = window.location.href;
            },
            error: function(xhr, status, thrown){
                console.log(xhr);
            }
        });
    }

    function sendAjax(data, method){
        $.ajax({
            method: method,
            data: data,
            url: window.ajax_url,
            success: function(response, status, request){
                localStorage.setItem('_token', response.access_token);
                window.location.href= "/cms";
            },
            error: function(xhr, status, thrown){
                console.log(xhr);
            }
        });
    }

    return {
        init: init,
        login:login,
        events: events,
        loadAnnouncements: loadAnnouncements
    };
})(jQuery);

app.events();