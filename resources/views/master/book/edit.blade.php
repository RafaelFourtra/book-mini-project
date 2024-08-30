<form id="form-edit">
    @csrf
    @method('put')
    <div class="modal-body">
        <input type="hidden" name="id-edit" id="id-edit" value="{{ $data->id }}">
        <div class="row">
            <div class="col-md-6">
                <label for="category_id-edit" class="form-label">Category <span class="text-danger">*</span></label>
                <select class="form-select category_id" name="category_id" id="category_id-edit">
                    <option disabled selected></option>
                    @foreach ($category as $item)
                        <option value="{{ $item->id }}" {{ $data->category_id == $item->id ? 'selected' : '' }}>
                            {{ $item->category }}</option>
                    @endforeach
                </select>
                <p id="error-message-category_id" style="font-size: 12px;"></p>
            </div>
            <div class="col-md-6">
                <label for="title-edit" class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control title" id="title-edit" name="title"
                    value="{{ $data->title }}">
                <p id="error-message-title" style="font-size: 12px;"></p>
            </div>
            <div class="col-md-6 mt-2">
                <label for="page_count-edit" class="form-label">Page Count <span class="text-danger">*</span></label>
                <input type="text" class="form-control page_count" id="page_count-edit" name="page_count"
                    value="{{ $data->page_count }}">
                <p id="error-message-page_count" style="font-size: 12px;"></p>
            </div>
            <div class="col-md-6 mt-2">
                <label for="writer_id-edit" class="form-label">Writer <span class="text-danger">*</span></label>
                <select class="form-select writer_id" name="writer_id" id="writer_id-edit">
                    <option disabled selected></option>
                    @foreach ($writer as $item)
                        <option value="{{ $item->id }}" {{ $data->writer_id == $item->id ? 'selected' : '' }}>
                            {{ $item->writer }}</option>
                    @endforeach
                </select>
                <p id="error-message-writer_id" style="font-size: 12px;"></p>
            </div>
            <div class="col-md-6 mt-2">
                <label for="publisher_id-edit" class="form-label">Publisher <span class="text-danger">*</span></label>
                <select class="form-select publisher_id" name="publisher_id" id="publisher_id-edit">
                    <option disabled selected></option>
                    @foreach ($publisher as $item)
                        <option value="{{ $item->id }}" {{ $data->publisher_id == $item->id ? 'selected' : '' }}>
                            {{ $item->publisher }}</option>
                    @endforeach
                </select>
                <p id="error-message-publisher_id" style="font-size: 12px;"></p>
            </div>
            <div class="col-md-6 mt-2">
                <label for="publication_year-edit" class="form-label">Publication Year <span class="text-danger">*</span></label>
                <input type="date" class="form-control publication_year" id="publication_year-edit" name="publication_year"
                    value="{{ $data->publication_year }}">
                <p id="error-message-publication_year" style="font-size: 12px;"></p>
            </div>
            <div class="col-md-6 mt-2">
                <label for="qty-edit" class="form-label">Quantity</label>
                <input type="number" class="form-control qty" id="qty-edit" name="qty"
                    value="{{ $data->qty }}">
                <p id="error-message-qty" style="font-size: 12px;"></p>
            </div>
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
        var updateUrl = baseUrl + `/book/${id}`;

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
                showBook()

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
