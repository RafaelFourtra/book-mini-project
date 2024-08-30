@extends('layouts/app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <h4 class="card-title fw-semibold float-start">Book</h4>
                    </div>
                    @if (auth()->user()->roles[0]->name == 'admin')
                        <div class="col-lg-6">
                            <button type="button" id="btn-create" class="btn btn-primary btn-md float-end">Create</button>
                        </div>
                    @endif
                </div>
                <hr>
                <div class="row mt-1">
                    <div class="table-responsive mt-4">
                        <table id="zero_config" class="display table table-striped table-hover data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Category</th>
                                    <th>Title</th>
                                    <th>Page Count</th>
                                    <th>Writer</th>
                                    <th>Publisher</th>
                                    <th>Publication Year</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
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
                        Book Create
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('book.store') }}" id="form-create">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="category_id" class="form-label">Category <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="category_id" id="category_id">
                                    <option disabled selected></option>
                                    @foreach ($category as $item)
                                        <option value="{{ $item->id }}">{{ $item->category }}</option>
                                    @endforeach
                                </select>
                                <p class="error-message-category_id" style="font-size: 12px;"></p>
                            </div>
                            <div class="col-md-6">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title">
                                <p class="error-message-title" style="font-size: 12px;"></p>
                            </div>
                            <div class="mt-2 col-md-6">
                                <label for="page_count" class="form-label">Page Count <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="page_count" name="page_count">
                                <p class="error-message-page_count" style="font-size: 12px;"></p>
                            </div>
                            <div class="mt-2 col-md-6">
                                <label for="writer_id" class="form-label">Writer <span class="text-danger">*</span></label>
                                <select class="form-select" name="writer_id" id="writer_id">
                                    <option disabled selected></option>
                                    @foreach ($writer as $item)
                                        <option value="{{ $item->id }}">{{ $item->writer }}</option>
                                    @endforeach
                                </select>
                                <p class="error-message-writer_id" style="font-size: 12px;"></p>
                            </div>
                            <div class="mt-2 col-md-6">
                                <label for="publisher_id" class="form-label">Publisher <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="publisher_id" id="publisher_id">
                                    <option disabled selected></option>
                                    @foreach ($publisher as $item)
                                        <option value="{{ $item->id }}">{{ $item->publisher }}</option>
                                    @endforeach
                                </select>
                                <p class="error-message-publisher_id" style="font-size: 12px;"></p>
                            </div>
                            <div class="mt-2 col-md-6">
                                <label for="publication_year" class="form-label">Publication Year <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="publication_year" name="publication_year">
                                <p class="error-message-publication_year" style="font-size: 12px;"></p>
                            </div>
                            <div class="mt-2 col-md-6">
                                <label for="qty" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="qty" name="qty">
                                <p class="error-message-qty" style="font-size: 12px;"></p>
                            </div>
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

    <div id="modal-edit" class="modal fade" tabindex="-1" aria-labelledby="warning-header-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-warning text-white">
                    <h4 class="modal-title text-white" id="warning-header-modalLabel">
                        Book Edit
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
            showBook()

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
                        showBook()

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

        function showBook() {
            const userRole = "{{ auth()->user()->roles[0]->name }}";
            const columns = [{
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: "category.category",
                    render: function(data, type, row) {
                        return data ? data : "";
                    }
                },
                {
                    data: "title"
                },
                {
                    data: "page_count",
                },
                {
                    data: "writer.writer",
                    render: function(data, type, row) {
                        return data ? data : "";
                    }
                },
                {
                    data: "publisher.publisher",
                    render: function(data, type, row) {
                        return data ? data : ""; // Menampilkan pesan jika email kosong
                    }
                },
                {
                    data: "publication_year"
                },
                {
                    data: "qty"
                },
                {
                    render: function(data, type, full, row) {
                        if (userRole === 'admin') {
                            return `
                    <button onclick="editBook(${full.id})" class="btn bg-warning text-light">Edit</button>
                    <button onclick="deleteBook(${full.id})" class="btn bg-danger text-light">Delete</button>
                    `;
                        } else {
                            return '-'; // Tampilkan tanda '-' jika bukan admin
                        }

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
                    url: "{{ route('book.index') }}",
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

        function editBook(id) {
            var baseUrl = "{{ url('/') }}";
            var editUrl = baseUrl + `/book/${id}/edit`;

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

        function deleteBook(id) {
            var baseUrl = "{{ url('/') }}";
            var deleteUrl = baseUrl + `/book/${id}`;

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

                    showBook()
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
