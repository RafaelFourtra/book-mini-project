@extends('layouts/app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <h4 class="card-title fw-semibold float-start">Writer</h4>
                    </div>
                    <div class="col-lg-6">
                        <button type="button" id="btn-create" class="btn btn-primary btn-md float-end">Create</button>
                    </div>
                </div>
                <hr>
                <div class="row mt-1">
                    <div class="table-responsive mt-4">
                        <table id="zero_config" class="display table table-striped table-hover data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Writer</th>
                                    <th>Account</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-create" class="modal fade" tabindex="-1" aria-labelledby="primary-header-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-md">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary text-white">
                    <h4 class="modal-title text-white" id="primary-header-modalLabel">
                        Writer Create
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('writer.store') }}" id="form-create">
                    @csrf
                    <div class="modal-body">
                        <div>
                            <label for="writer" class="form-label">Writer <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="writer" name="writer">
                            <p class="error-message-writer" style="font-size: 12px;"></p>
                        </div>
                        <div class="mt-2">
                            <label for="user_id" class="form-label">Account</label>
                            <select class="form-select" name="user_id" id="user_id">
                                <option disabled selected></option>
                                @foreach ($user as $item)
                                    <option value="{{ $item->id }}">{{ $item->email }}</option>
                                @endforeach
                            </select>
                            <p class="error-message-user_id" style="font-size: 12px;"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-primary-subtle text-primary">
                            Save
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div id="modal-edit" class="modal fade" tabindex="-1" aria-labelledby="warning-header-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-md">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-warning text-white">
                    <h4 class="modal-title text-white" id="warning-header-modalLabel">
                        Writer Edit
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="edit-div">

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            showWriter()

            $('#btn-create').click(function() {
                $('#modal-create').modal('show')
            })

            $('#form-create').submit(function(e) {
                e.preventDefault();

                const url = this.getAttribute('action')
                $.ajax({
                    url: url,
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
                            text: "Data added successfully!",
                            icon: "success",
                        });
                        $('#modal-create').modal('hide')
                        $('#form-create').trigger('reset')
                        showWriter()

                    },
                    error: function(res) {
                        Swal.close();
                        try {
                            const errors = JSON.parse(res.responseText).errors;
                            for (const fieldName in errors) {
                                const input = $(`#${fieldName}`);
                                const errorMessage = errors[fieldName][0];
                                input.addClass('border border-danger');
                                $(`.error-message-${fieldName}`).text(
                                    errorMessage).addClass('text-danger');
                            }


                        } catch (e) {
                            Swal.fire({
                                title: "Error",
                                text: "An error occurred in the system. Please try again later.",
                                icon: "error",
                                onClose: function() {
                                    $('#modal-create').modal('hide')
                                }
                            });
                        }
                    }
                })

            });


        })

        function showWriter() {
            const columns = [{
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: "writer"
                },
                {
                    data: "user.email",
                    render: function(data, type, row) {
                        return data ? data : ""; 
                    }
                },
                {
                    render: function(data, type, full, row) {
                        return `
                    <button onclick="editWriter(${full.id})"  class="btn bg-warning text-light">Edit</button>
                    <button onclick="deleteWriter(${full.id})" class="btn bg-danger text-light">Delete</button>
                    `
                    }
                },
            ];

            $('.data-table').DataTable({
                scrollCollapse: true,
                destroy: true,
                autoWidth: false,
                responsive: true,
                searching: true,
                bLengthChange: true,
                bPaginate: true,
                bInfo: true,
                ajax: {
                    url: "{{ route('writer.index') }}",
                    // data: filterData
                },
                columns: columns,
                columnDefs: [{
                    targets: "datatable-nosort",
                    orderable: false,
                }],
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "language": {
                    searchPlaceholder: "Search",
                    paginate: {
                        next: '<i class="ti ti-chevron-right"></i>',
                        previous: '<i class="ti ti-chevron-left"></i>'
                    }
                },
            });
        }

        function editWriter(id) {
            var baseUrl = "{{ url('/') }}";
            var editUrl = baseUrl + `/writer/${id}/edit`;

            $.ajax({
                url: editUrl,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('.edit-div').html(response)
                    $('#modal-edit').modal('show')
                },
                error: function(res) {
                    Swal.fire({
                        title: "Error",
                        text: "An error occurred in the system. Please try again later.",
                        icon: "error",
                    });
                }
            })
        }

        function deleteWriter(id) {
            var baseUrl = "{{ url('/') }}";
            var deleteUrl = baseUrl + `/writer/${id}`;

            $.ajax({
                url: deleteUrl,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
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
                        text: "Data deleted successfully!",
                        icon: "success",
                    });

                    showWriter()
                },
                error: function(res) {
                    Swal.close();
                    Swal.fire({
                        title: "Error",
                        text: "An error occurred in the system. Please try again later.",
                        icon: "error",
                    });
                }
            })
        }
    </script>
@endsection
