<form id="form-edit">
    @csrf
    @method('put')
    <div class="modal-body">
        <input type="hidden" name="id-edit" id="id-edit" value="{{ $data->id }}">
        <div>
            <label for="name-edit" class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control name" id="name-edit" name="name" value="{{ $data->name }}">
            <p id="error-message-name" style="font-size: 12px;"></p>
        </div>
        <div class="mt-2">
            <label for="email-edit" class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control email" id="email-edit" name="email" value="{{ $data->email }}">
            <p id="error-message-email" style="font-size: 12px;"></p>
        </div>
        <div class="mt-2">
            <label for="role-edit" class="form-label">Role <span class="text-danger">*</span></label>
            <select class="form-select role" name="role" id="role-edit">
                <option disabled selected></option>
                <option value="admin" {{ $data->roles[0]->name == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="writer" {{ $data->roles[0]->name == 'writer' ? 'selected' : '' }}>Writer</option>
            </select>
            <p id="error-message-role" style="font-size: 12px;"></p>
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
        var updateUrl = baseUrl + `/user/${id}`;

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
                showUser()

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
