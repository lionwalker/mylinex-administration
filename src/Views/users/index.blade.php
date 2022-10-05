@extends('layouts.app')
@section('title','Users')
@section('content')
    <div class="hk-pg-header">
        <h4 class="hk-sec-title">All users</h4>
        <button type="button" class="btn btn-primary bg-primary-blue" data-toggle="modal"
                data-target="#userCreateModal">
            New User
        </button>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <table id="userTable" class="table table-hover w-100 display">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="modal fade " id="userCreateModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalForms"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title">Create new user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body mt-3 mb-3">
                    {!! Form::open(['method' => 'post', 'id' => 'userCreateForm']) !!}
                    @include('Administration::users.form')
                    <div class="float-right">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button
                            onclick="FormOptions.submitForm('userCreateForm','userCreateModal','userTable')"
                            type="button" class="btn btn btn-outline-primary-blue">Create
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="userEditModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalForms"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title">Edit user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body mt-3 mb-3">
                    {!! Form::open(['method' => 'put', 'id' => 'userEditForm','class'=>'needs-validation','novalidate']) !!}
                    @include('Administration::users.form',['edit'=>true])
                    <div class="float-right">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button
                            onclick="FormOptions.submitForm('userEditForm','userEditModal','userTable')"
                            type="button" class="btn btn-outline-primary-blue">Update now
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="userResetModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalForms"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title">Reset user password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body mt-3 mb-3">
                    {!! Form::open(['method' => 'put', 'id' => 'userResetForm','class'=>'needs-validation','novalidate']) !!}
                    @include('Administration::users.form',['reset'=>true])
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="float-right">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button
                            onclick="FormOptions.submitForm('userResetForm','userResetModal','userTable')"
                            type="button" class="btn btn-outline-primary-blue">Reset now
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    @include('Administration::layouts.includes.styles.form')
    <link href="{{asset('plugins/datatables/jquery.dataTables.css')}}" rel="stylesheet" type="text/css"/>
@endpush

@push('scripts')
    @include('Administration::layouts.includes.scripts.form')
    <!-- Data Table JavaScript -->
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTable.js')}}"></script>
    <script src="{{asset('js/dataTables-data.js')}}"></script>

    <script>
        DataTableOption.initDataTable('userTable', 'users/table/data');
        // FormOptions.initValidation('userCreateForm');
        FormOptions.initValidation('userEditForm');

        var xds = false;

        function checkRecentlyUsed(value) {
            self.xds = xds;
            $.ajax({
                url: '/recently_used_pw',
                type: 'POST',
                async: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    password: value,
                    user_id: $("#userResetForm").find('#user_id').val(),
                },
                dataType: 'JSON',
                success: function (data) {
                    self.xds = data;
                }
            });
            return self.xds;
        }

        $.validator.addMethod(
            "checkRecentlyUsed",
            function (value , element){
                return checkRecentlyUsed(value);
            },
            "Not allowed to add 24 previous passwords as new password."
        );

        $.validator.addMethod(
            "regex",
            function (value, element, regexp) {
                var re = new RegExp(regexp);
                return this.optional(element) || re.test(value);
            },
            "Password must be of 8-14 characters in length and have one or more special character and one or more number and one or more uppercase character."
        );

        $("#userCreateForm").validate({
            rules: {
                password: {
                    regex: "^(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[A-Z])(?=.*[a-z])[a-zA-Z0-9!@#$%^&*]{8,14}$",
                    minlength: 8,
                },
                txtConfirmPassword: {
                    regex: "^(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[A-Z])(?=.*[a-z])[a-zA-Z0-9!@#$%^&*]{8,14}$",
                    equalTo: "#password",
                    minlength: 8
                }
            }
        });

        $("#userResetForm").validate({
            rules: {
                password: {
                    regex: "^(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[A-Z])(?=.*[a-z])[a-zA-Z0-9!@#$%^&*]{8,14}$",
                    minlength: 8,
                    checkRecentlyUsed: true
                },
                txtConfirmPassword: {
                    regex: "^(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[A-Z])(?=.*[a-z])[a-zA-Z0-9!@#$%^&*]{8,14}$",
                    equalTo: "#userResetForm #password",
                    minlength: 8
                }
            }
        });

        

        function edit(role) {
            let id = role.dataset.id;
            let name = role.dataset.name;
            let email = role.dataset.email;
            let roles = role.dataset.roles;
            $("#userEditForm").find('.name').val(name);
            $("#userEditForm").find('.email').val(email);


            let roleName = roles.replace('["', '');
            roleName = roleName.replace('"]', '');

            $("#userEditForm").find('.role').val(roleName);


            $("#userEditForm").attr('action', '/users/' + id);
            ModalOptions.toggleModal('userEditModal');
        }

        function reset(role) {
            let id = role.dataset.id;

            $("#userResetForm").find('#user_id').val(id);
            $("#userResetForm").attr('action', '/users/' + id + '/reset');
            ModalOptions.toggleModal('userResetModal');
        }

        function resetAttempt(user) {
            let id = user.dataset.id;
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to unlocked?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, unlocked it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "get",
                        url: '/users/unlock/' + id,
                        success: function (response) {
                            if (response.success) {
                                $('#userTable').DataTable().ajax.reload();
                                Swal.fire(
                                    'Unlocked!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            } else {
                                Swal.fire("Error!", "Something went wrong", "error");
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            Swal.fire("Error!", "Something went wrong", "error");
                        }
                    });
                }
            })
        }

    </script>
@endpush
