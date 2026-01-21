@extends('layouts.master')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    {{-- <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="tool"></i></div>
                            Dropdown App Menu
                        </h1>
                        <div class="page-header-subtitle">Use this blank page as a starting point for creating new pages inside your project!</div>
                    </div>
                    <div class="col-12 col-xl-auto mt-4">Optional page header content</div>
                </div> --}}
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-xl mt-n10 px-4">
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    {{-- <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>    </h1>
          </div>
        </div>
      </div><!-- /.container-fluid --> --}}
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">List of Dropdown</h3>
                                    </div>

                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 mb-3">
                                                <button type="button" class="btn btn-dark btn-sm mb-2"
                                                    data-bs-toggle="modal" data-bs-target="#modal-add">
                                                    <i class="fas fa-plus-square"></i>
                                                </button>
                                            </div>
                                            <div class="table-responsive">
                                                <table id="tableUser" class="table-bordered table-striped table">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Category</th>
                                                            <th>Name Value</th>
                                                            <th>Code Format</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
            </div>
        </div>

        {{-- modal --}}
        <div class="modal fade" id="modal-update">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="updateForm" method="POST">
                        @csrf
                        @method('patch')
                        <div class="modal-header">
                            <h5>Edit Dropdown</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input class="form-control mb-2" id="edit_category" name="category">
                            <input class="form-control mb-2" id="edit_name_value" name="name_value">
                            <input class="form-control" id="edit_code_format" name="code_format">
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-add" tabindex="-1" aria-labelledby="modal-add-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-add-label">Add Dropdown
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ url('/dropdown/store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" id="category" name="category"
                                    placeholder="Enter Dropdown Category" required>
                            </div>
                            <br>
                            <div class="form-group">
                                <input type="text" class="form-control" id="name_value" name="name_value"
                                    placeholder="Enter Dropdown Name Value" required>
                            </div>
                            <br>
                            <div class="form-group">
                                <input type="text" class="form-control" id="code_format" name="code_format"
                                    placeholder="Enter Dropdown Code Format" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </main>
    <script>
        $(function() {
            const table = $('#tableUser').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: "{{ route('dropdown.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'name_value',
                        name: 'name_value'
                    },
                    {
                        data: 'code_format',
                        name: 'code_format'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#tableUser').on('click', '.btn-edit', function() {
                const id = $(this).data('id');

                $('#edit_category').val($(this).data('category'));
                $('#edit_name_value').val($(this).data('name'));
                $('#edit_code_format').val($(this).data('code'));

                const url = "{{ route('dropdown.update', ':id') }}".replace(':id', id);
                $('#updateForm').attr('action', url);

                $('#modal-update').modal('show');
            });

            $('#tableUser').on('submit', '.delete-form', async function(e) {
                e.preventDefault();

                if (!await confirmAction({
                        title: 'Delete Dropdown?',
                        text: 'This data will be permanently deleted.'
                    })) return;

                this.submit();
            });
        });
    </script>
@endsection
