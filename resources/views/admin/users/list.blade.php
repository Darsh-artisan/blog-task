@extends('admin.layouts.admin-layout')

@section('title', 'Users')

@section('content')

<div class="pagetitle">
    <h1>Users</h1>
    <div class="row">
        <div class="col-md-8">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-4" style="text-align: right;">
            <a href="{{ route('users.create') }}" class="btn btn-sm new-category custom-btn">
                <i class="bi bi-plus-lg"></i>
            </a>
        </div>
    </div>
</div>

 {{-- Category Section --}}
 <section class="section dashboard">
    <div class="row">

        {{-- Categories Card --}}
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                    </div>
                    <div class="table-responsive custom_dt_table">
                        <table class="table w-100" id="UsersTable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection


{{-- Custom Script --}}
@section('page-js')


    <script type="text/javascript">
        $(function() {

            var table = $('#UsersTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                ajax: "{{ route('users') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

        });


        // Function for Delete Table
        function deleteUsers(userId) {
            swal({
                    title: "Are you sure You want to Delete It ?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDeleteUsers) => {
                    if (willDeleteUsers) {
                        $.ajax({
                            type: "POST",
                            url: '{{ route('users.destroy') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'id': userId,
                            },
                            dataType: 'JSON',
                            success: function(response) {
                                if (response.success == 1) {
                                    toastr.success(response.message);
                                    $('#UsersTable').DataTable().ajax.reload();
                                } else {
                                    swal(response.message, "", "error");
                                }
                            }
                        });
                    } else {
                        swal("Cancelled", "", "error");
                    }
                });
        }
    </script>

@endsection
