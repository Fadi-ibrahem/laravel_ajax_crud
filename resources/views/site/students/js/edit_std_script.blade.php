<script>
    $(document).ready(function() {
        // Global Variables
        const editModal     = $('#edit-std-modal');
        const editForm      = $('#edit-std-form');
        var studentID       = null;
        var studentName     = null;
        var studentEmail    = null;

        $('body').on('click', '.edit-btn', function() {
            // Get specific student data & define needed variables
            window.editBtn  = $(this);
            studentName     = window.editBtn.parents('tr').find("td:nth-child(2)").html();
            studentEmail    = window.editBtn.parents('tr').find("td:nth-child(3)").html();
            studentID       = window.editBtn.attr('data-id');

            // Show the modal
            editModal.modal('show');

            // Fill student data into the modal form
            editForm.find('input[name="name"]').val(studentName);
            editForm.find('input[name="email"]').val(studentEmail);
        });

        $('body').on('click', '#edit-std-modal .update-btn', function() {
            var url         = "{{url('/students')}}" + "/" + studentID;
            var formData    = editForm.serializeArray();

            $.ajax({
                'type'      : 'PUT',
                'url'       : url,
                'data'      : formData,
                'success'   : function(response) {
                    if(response.success) {
                        // Clear all form fields except csrf & method fields
                        editForm.find('input:not([name="_token"]):not([name="_method"])').val("");

                        // Hide edit modal
                        editModal.modal('hide');
                        
                        // Display success message
                        toastr.success(response.message);

                        /*
                        * Begin Replacing The Updated Student Row
                        */
                        var oldRow          = window.editBtn.parents('tr');
                        var rowIteration    = oldRow.children().first().html();
                        var studentID       = response.data.id;
                        var studentName     = response.data.name;
                        var studentEmail    = response.data.email;
                        var csrf            = `@csrf`;
                        var method          = `@method('DELETE')`;
                        var formUrl         = "{{url('/students')}}" + "/" + studentID;

                        var newStudentRow   = `
                            <tr>
                                <th>${rowIteration}</th>
                                <td>${studentName}</td>
                                <td>${studentEmail}</td>
                                <td>
                                    <a class="btn btn-info edit-btn" data-id="${studentID}">
                                        Edit
                                    </a>
                                    <form action="${formUrl}" method="POST" class="delete-form d-inline-block">
                                        ${csrf}
                                        ${method}
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        `;

                        $(newStudentRow).insertBefore(oldRow);
                        oldRow.remove();
                        /*
                        * End Replacing The Updated Student Row
                        */

                    } else {
                        $.each(response.data, function(index, error) {
                            toastr.error(error);
                        });
                    }
                },
                'error'     : function(response) {
                    toastr.error('There is an error');
                    console.log(response.data);
                },
            });
        });
    });
</script>