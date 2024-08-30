<form id="form-edit">
    @csrf
    @method('put')
    <div class="modal-body">
        <input type="hidden" name="id-edit" id="id-edit" value="{{ $data->id }}">
        <div>
            <label for="publisher-edit" class="form-label">Publisher <span class="text-danger">*</span></label>
            <input type="text" class="form-control publisher" id="publisher-edit" name="publisher" value="{{ $data->publisher }}">
            <p id="error-message-publisher" style="font-size: 12px;"></p>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn bg-warning-subtle text-warning">
            Save changes
        </button>
    </div>
</form>

<script>
    $('#form-edit').submit(function(e) {
        e.preventDefault();

        var id = $('#id-edit').val();
        var baseUrl = "{{ url('/') }}";
        var updateUrl = baseUrl + `/publisher/${id}`;

        $.ajax({
            url: updateUrl,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function() {
                Swal.fire({
                    allowOutsideClick: false,
                    title: 'Please Wait',
                    text: 'Your request is being processed. This may take a moment.',
                    showCancelButton: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                Swal.fire({
                    title: "Succcess",
                    text: "Data updated successfully!",
                    icon: "success",
                });
                $('#modal-edit').modal('hide')
                $('#form-edit').trigger('reset')
                showPublisher()

            },
            error: function(res) {
                Swal.close();
                try {
                    const errors = JSON.parse(res.responseText).errors;
                    for (const fieldName in errors) {
                        const input = $(`.${fieldName}`);
                        const errorMessage = errors[fieldName][0];
                        input.addClass('border border-danger');
                        $(`#error-message-${fieldName}`).text(
                            errorMessage).addClass('text-danger');
                    }


                } catch (e) {
                    Swal.fire({
                        title: "Error",
                        text: "An error occurred in the system. Please try again later.",
                        icon: "error",
                        onClose: function() {
                            $('#modal-edit').modal('hide')
                        }
                    });
                }
            }
        })

    });
</script>
