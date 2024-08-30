<form id="form-edit">
    @csrf
    @method('put')
    <div class="modal-body">
        <input type="hidden" name="id-edit" id="id-edit" value="{{ $data->id }}">
        <div>
            <label for="writer-edit" class="form-label">Writer <span class="text-danger">*</span></label>
            <input type="text" class="form-control writer" id="writer-edit" name="writer"
                value="{{ $data->writer }}">
            <p id="error-message-writer" style="font-size: 12px;"></p>
        </div>
        <div class="mt-2">
            <label for="user_id-edit" class="form-label">Account <span class="text-danger">*</span></label>
            <select class="form-select user_id" name="user_id" id="user_id-edit">
                <option disabled selected></option>
                @foreach ($user as $item)
                    <option value="{{ $item->id }}" {{ $data->user_id == $item->id ? 'selected' : '' }}>{{ $item->email }}</option>
                @endforeach
            </select>
            <p id="error-message-user_id" style="font-size: 12px;"></p>
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
        var updateUrl = baseUrl + `/writer/${id}`;

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
                showWriter()

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
