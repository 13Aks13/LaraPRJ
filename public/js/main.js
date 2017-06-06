jQuery(document).ready(function(){
$( ".status-changed" ).on('click',function() {
    $.ajax({
        url: "/update-user-status",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        data: {user_id : $('#user_id').val(), status_id : $(this).data('statusid') }
    }).success( function(data) {
        $( '.status-current-err' ).hide();
        $('.status-current').html(data.status_name);
    }).error( function(data)
        {   //console.log(data);
            $( '.status-current-err' ).html( data.responseText );
            $( '.status-current-err' ).show();
        }
    );
});
});
