<script>
    $(document).ready(function() {
        $('body').on('submit', '.delete-form', function(event) {
            event.preventDefault();
            const form      = $(this);
            var formData    = form.serializeArray();
            var url         = form.attr('action');
            
            $.ajax({
                'type'      : 'POST',
                'url'       : url,
                'data'      : formData,
                'success'   : function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        form.parents("tr").remove();
                    } else {
                        toastr.error(response.message);
                    }
                },
                'error'     : function(response) {
                    toastr.error('There is an error');
                    console.log(response.error);
                },
            });
        });

    });
</script>