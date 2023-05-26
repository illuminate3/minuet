$('.thread-table a.show_confirm_pin').on("click",function(event) {
    event.preventDefault();
    swal({
        title: $(this).data("msg"),
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                method: 'POST',
                url: "/user/thread/"+$(this).data("id")+"/update_pin_status",
                data: {id: $(this).data("id"), ispin: $(this).data("values")},
            })
            .done(function (result) {
                if(result.status == 'success' && result.data == false)
                {
                    $('#pin-'+result.id).html('No');
                    $('#pin-row-'+result.id).data('values', '1');
                    $('#pin-row-'+result.id).data('msg', 'Are you sure you want to unpin this thread?');
                    $('#pin-row-'+result.id).html("<i class='fa-solid fa-thumbtack btn-light-gray'></i>");
                    $('#pin-row-'+result.id).attr('title', 'Unpin');
                }
                if(result.status == 'success' && result.data == true)
                {
                    $('#pin-'+result.id).html('Yes');
                    $('#pin-row-'+result.id).data('values', '0'); 
                    $('#pin-row-'+result.id).data('msg', 'Are you sure you want to pin this thread?');  
                    $('#pin-row-'+result.id).html("<i class='fa-solid fa-thumbtack btn-black'></i>");
                    $('#pin-row-'+result.id).attr('title', 'Pin');
                }
            })
            .fail(function () {
                bootbox.alert('An error has occurred');
            });
        }
    });
});

$('.thread-table a.show_confirm_close').on("click",function(event) {
    event.preventDefault();
    swal({
        title: $(this).data("msg"),
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                method: 'POST',
                url: "/user/thread/"+$(this).data("id")+"/update_close_status",
                data: {id: $(this).data("id"), ispin: $(this).data("values")},
            })
            .done(function (result) {
                if(result.status == 'success' && result.data == false)
                {
                    $('#close-'+result.id).html('No');
                    $('#close-row-'+result.id).data('values', '1');
                    $('#close-row-'+result.id).data('msg', 'Are you sure you want to open this thread?');
                    $('#close-row-'+result.id).html("<i class='fa-solid fa-circle-xmark btn-red'></i>");
                    $('#close-row-'+result.id).attr('title', 'Close');
                }
                if(result.status == 'success' && result.data == true)
                {
                    $('#close-'+result.id).html('Yes');
                    $('#close-row-'+result.id).data('values', '0');  
                    $('#close-row-'+result.id).data('msg', 'Are you sure you want to close this thread?');
                    $('#close-row-'+result.id).html("<i class='fa-solid fa-circle-check btn-green'></i>");
                    $('#close-row-'+result.id).attr('title', 'Open');
                }
            })
            .fail(function () {
                bootbox.alert('An error has occurred');
            });
        }
    });
});

$('.show_confirm_delete').on("click",function(event) {
    event.preventDefault();
    let $form = $('.delete_form');
    let token = $("input[name*='_token']").val()
    var messageId = $("input[name*='message_id']").val();
    var threadId = $("input[name*='thread_id']").val();
    swal({
        title: 'Are you sure you want to delete this thread message?',
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                method: 'POST',
                url: "/user/message/"+messageId,
                data: { csrf_token: token, id: messageId , thread_id: threadId}
            })
            .done(function (result) {
                bootbox.alert('Deleted successfully',function(){
                    window.location.href = '/user/message/thread/'+result.data;
                });
                
            })
            .fail(function () {
                bootbox.alert('An error has occurred');
            });
        }
    });
});

$('.show_confirm_delete_staff').on("click",function(event) {
    event.preventDefault();
    let $form = $('.delete_form');
    let token = $("input[name*='_token']").val()
    var userId = $("input[name*='user_id']").val();
    swal({
        title: 'Are you sure you want to delete this staff member?',
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                method: 'POST',
                url: "/dealer/"+userId,
                data: { csrf_token: token, id: userId}
            })
            .done(function (result) {
                bootbox.alert('Deleted successfully',function(){
                    window.location.href = '/dealer';
                });
                
            })
            .fail(function () {
                bootbox.alert('An error has occurred');
            });
        }
    });
});