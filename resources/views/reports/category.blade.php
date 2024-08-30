@extends('layouts/app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <h4 class="card-title fw-semibold float-start">Report Book By Publisher</h4>
                    </div>
                    <div class="col-lg-6">
                        <form class="row justify-content-end" id="search">
                            <div class="co-lg-4">

                            </div>
                            <div class="col-lg-6">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" name="category" id="category">
                                    <option disabled selected></option>
                                    @foreach ($category as $item)
                                        <option value="{{ $item->id }}">{{ $item->category }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <button type="button" style="margin-bottom: -15px;" onclick="search()" id="btn-search"
                                    class="btn btn-primary btn-lg mt-4"><i class="ti ti-search"></i></button>
                            </div>
                        </form>
                    </div>
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
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            showBook()

        })

        function showBook(filterData = $('#search').serialize()) {
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
            ];

            $('.data-table').DataTable({
                scrollCollapse: true,
                destroy: true,
                autoWidth: false,
                responsive: true,
                searching: false,
                bLengthChange: false,
                bPaginate: true,
                bInfo: true,
                ajax: {
                    url: "{{ route('reports.category') }}" + `?${filterData}`,
                    // data: filterData
                },
                columns: columns,
                order: [
                    [7, 'desc'] 
                ],
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

        const search = () => {
            showBook($('#search').serialize());
        }
    </script>
@endsection
