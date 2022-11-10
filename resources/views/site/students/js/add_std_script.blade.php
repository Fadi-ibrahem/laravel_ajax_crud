<script>
    $(document).ready(function() {
        const addStdModal           = $('#add-std-modal');

        $('#add-btn').click(function() {
            addStdModal.modal('show');
        });

        $('.save-btn').click(function() {
            // var test = $('input[name="name"]').val()
            var formData    = $('#add-std-form').serializeArray();
            var url         = $('#add-std-form').attr('action');

            /*
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            */

            $.ajax({
                'type'      : 'POST',
                'url'       : url,
                'data'      : formData,
                'success'   : function(response) {
                    if(response.success) {
                        addStdModal.modal('hide');

                        // Clear all form fields except csrf
                        $('#add-std-form input:not([name="_token"])').val('');
                        toastr.success(response.message);

                        /**
                         * Begin generating new record in the table
                        */
                        var csrf            = `@csrf`;
                        var method          = `@method('DELETE')`;
                        var stdID           = response.data.id;
                        var stdName         = response.data.name;
                        var stdEmail        = response.data.email;
                        var formRoute       = "{{url('/students')}}" + "/" + stdID;
                        var currentNum      = $('tbody').children().last().children().first().html();
                        var iterationNum    = (isNaN(currentNum)) ? 1 : parseInt(currentNum) + 1;

                        // The new row
                        var newStudentRow = `
                            <tr>
                                <th>${iterationNum}</th>
                                <td>${stdName}</td>
                                <td>${stdEmail}</td>
                                <td>
                                    <a class="btn btn-info" id="${stdID}">
                                        Edit
                                    </a>
                                    <form action="${formRoute}" method="POST" class="delete-form d-inline-block" >
                                        ${csrf}
                                        ${method}
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        `;

                        // Append the new row
                        $('tbody').append(newStudentRow);
                        /**
                         * End generating new record in the table
                        */

                    } else {
                        // Display validation errors
                        $.each(response.data, function(field, error) {
                            toastr.error(error);
                        });
                    }
                },
                'error'     : function(data) {
                    toastr.error('There is an error');
                    console.log(data);
                },
            });
        });
    });
</script>