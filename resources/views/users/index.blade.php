@extends('layouts.master')

@section('content')
    <main>
        <!-- Header (Menggunakan format tema admin yang diminta) -->
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-fluid px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon">
                                    <i data-feather="file-text"></i>
                                </div>
                                User
                            </h1>
                            <div class="page-header-subtitle">
                                User Management.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-fluid mt-n10 px-4">
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
                                        <h3 class="card-title">List of User</h3>
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
                                            <table id="tableUser" class="table-bordered table-striped table">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Username</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Last Login</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
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

        {{-- Modal --}}
        <div class="modal fade" id="modal-edit-user" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="editUserForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div class="modal-header">
                            <h5 class="modal-title">Edit User</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                {{-- LEFT --}}
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" id="edit_name" name="name" required>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label>Username</label>
                                        <input type="text" class="form-control" id="edit_username" name="username"
                                            required>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label>Avatar</label>
                                        <input type="file" class="form-control" name="avatar"
                                            accept="image/png,image/jpeg">
                                        <small class="text-muted">JPG / PNG, max 2MB</small>
                                    </div>
                                </div>

                                {{-- RIGHT --}}
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label>Email</label>
                                        <input type="email" class="form-control" id="edit_email" name="email" required>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label>New Password</label>
                                        <input type="password" class="form-control" name="password"
                                            placeholder="Leave blank to keep current password">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-add" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                {{-- LEFT --}}
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label>Username</label>
                                        <input type="text" class="form-control" name="username" required>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label>Avatar</label>
                                        <input type="file" class="form-control" name="avatar"
                                            accept="image/png,image/jpeg">
                                        <small class="text-muted">JPG / PNG, max 2MB</small>
                                    </div>
                                </div>

                                {{-- RIGHT --}}
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </main>
    <script>
        window.routes = {
            userUpdate: "{{ route('user.update', ':id') }}",
            userRevoke: "{{ route('user.revoke', ':id') }}",
            userActivate: "{{ route('user.activate', ':id') }}",
        }

        $(function() {
            $('#tableUser').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('user.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'last_login',
                        name: 'last_login'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                responsive: true,
                lengthChange: false,
                autoWidth: false
            });

            $('#topicSupervisor').select2({
                placeholder: 'Select Supervisor',
                width: '100%',
                theme: 'bootstrap-5',
                dropdownParent: $('#modal-add')
            });
        });

        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-edit-user');
            if (!btn) return;

            document.getElementById('edit_name').value = btn.dataset.name;
            document.getElementById('edit_username').value = btn.dataset.username;
            document.getElementById('edit_email').value = btn.dataset.email;

            document.getElementById('editUserForm').action =
                window.routes.userUpdate.replace(':id', btn.dataset.id);

            new bootstrap.Modal(
                document.getElementById('modal-edit-user')
            ).show();
        });

        document.addEventListener('click', async function(e) {
            const btn = e.target.closest('.btn-revoke-user');
            if (!btn) return;

            e.preventDefault();

            const confirmed = await confirmAction({
                title: 'Revoke user access?',
                text: `User ${btn.dataset.email} will not be able to login`
            });

            if (!confirmed) return;

            await fetch(window.routes.userRevoke.replace(':id', btn.dataset.id), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            Toast.fire({
                icon: 'success',
                title: 'User revoked'
            });
            $('#tableUser').DataTable().ajax.reload(null, false);
        });

        document.addEventListener('click', async function(e) {
            const btn = e.target.closest('.btn-activate-user');
            if (!btn) return;

            e.preventDefault();

            const confirmed = await confirmAction({
                title: 'Activate user?',
                text: `User ${btn.dataset.email} will be able to login`
            });

            if (!confirmed) return;

            await fetch(window.routes.userActivate.replace(':id', btn.dataset.id), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            Toast.fire({
                icon: 'success',
                title: 'User activated'
            });
            $('#tableUser').DataTable().ajax.reload(null, false);
        });
    </script>
@endsection
