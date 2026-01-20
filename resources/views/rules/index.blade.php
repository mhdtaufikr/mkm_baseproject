@extends('layouts.master')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-xl mt-n10 px-4">
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">List of Rule</h3>
                                    </div>
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
                                                            <th>Rule Name</th>
                                                            <th>Rule Value</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal-add" tabindex="-1" aria-labelledby="modal-add-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-add-label">Add Rule</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ url('/rule/store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" id="rule_name" name="rule_name"
                                    placeholder="Enter Rule Name" required>
                            </div>
                            <br>
                            <div class="form-group">
                                <input type="text" class="form-control" id="rule_value" name="rule_value"
                                    placeholder="Enter Rule Value" required>
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

        {{-- Modal Access --}}
        <div class="modal fade" id="modal-access}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Give User Access</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('') }}" enctype="multipart/form-data" method="GET">
                        @csrf
                        <div class="modal-body">

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-dark btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        {{-- Modal Update --}}
        <div class="modal fade" id="modal-update">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="updateForm" method="POST">
                        @csrf
                        @method('patch')
                        <div class="modal-header">
                            <h5>Edit Rule</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input class="form-control mb-2" name="rule_name" id="edit_rule_name">
                            <input class="form-control" name="rule_value" id="edit_rule_value">
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </main>
    <!-- For Datatables -->
    <script>
        $(function() {
            const table = $('#tableUser').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                ajax: "{{ route('rules.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'rule_name',
                        name: 'rule_name'
                    },
                    {
                        data: 'rule_value',
                        name: 'rule_value'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#tableUser').on('submit', '.delete-form', async function(e) {
                e.preventDefault();

                if (!await confirmAction({
                        title: 'Delete Rule?',
                        text: 'This rule will be permanently deleted.'
                    })) return;

                this.submit();
            });

            $('#tableUser').on('click', '.btn-edit', function() {

                const id = $(this).data('id');
                const name = $(this).data('name');
                const value = $(this).data('value');

                $('#edit_rule_name').val(name);
                $('#edit_rule_value').val(value);

                const updateUrl = "{{ route('rules.update', ':id') }}".replace(':id', id);
                $('#updateForm').attr('action', updateUrl);

                $('#modal-update').modal('show');
            });
        });
    </script>
@endsection
