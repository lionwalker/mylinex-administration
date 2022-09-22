@extends('layouts.app')
@section('title','Roles')
@section('content')
    <div class="hk-pg-header">
        <h4 class="hk-sec-title">All roles</h4>
        <button type="button" class="btn btn-primary bg-primary-blue" data-toggle="modal"
                data-target="#roleCreateModal">
            New Role
        </button>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <table id="roleTable" class="table table-hover w-100 display">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Role Name</th>
                                    <th>Permissions</th>
                                    <th>Guard</th>
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

    <div class="modal fade" id="roleCreateModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalForms"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title">Create new role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body mt-3 mb-3">
                    {!! Form::open(['method' => 'post', 'id' => 'roleCreateForm']) !!}
                    @include('Administration::role.form', ['formId' => '#roleCreateForm'])
                    <div class="float-right">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button
                            onclick="FormOptions.submitForm('roleCreateForm','roleCreateModal','roleTable')"
                            type="button" class="btn btn btn-outline-primary-blue">Create
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="roleEditModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalForms"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title">Edit role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body mt-3 mb-3">
                    {!! Form::open(['method' => 'put', 'id' => 'roleEditForm','class'=>'needs-validation','novalidate']) !!}
                    @include('Administration::role.form', ['formId' => '#roleEditForm'])
                    <div class="float-right">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button
                            onclick="FormOptions.submitForm('roleEditForm','roleEditModal','roleTable')"
                            type="button" class="btn btn-outline-primary-blue">Update now
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
@push('styles')
<<<<<<< HEAD
=======
    @include('Administration::layouts.includes.styles.form')
>>>>>>> 5a30cd9e87500e6db79439b4567c5d6399381e48
    <link href="{{asset('plugins/datatables/jquery.dataTables.css')}}" rel="stylesheet" type="text/css"/>
@endpush

@push('scripts')
<<<<<<< HEAD
=======
    @include('Administration::layouts.includes.scripts.form')
>>>>>>> 5a30cd9e87500e6db79439b4567c5d6399381e48
    <!-- Data Table JavaScript -->
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTables-data.js')}}"></script>

    <script>
        DataTableOption.initDataTable('roleTable', 'roles/table/data');
        FormOptions.initValidation('roleCreateForm');
        FormOptions.initValidation('roleEditForm');

        function toggleAllPermissions(formId)
        {
            if ($(formId).find('.select-all-permissions').is(':checked')) {
                $(formId).find('.permissions').prop('checked',true);
            } else {
                $(formId).find('.permissions').prop('checked',false);
            }
        }

        function editPermission(role) {
            let id = role.dataset.id;
            let name = role.dataset.name;
            let permissions = role.dataset.permissions;
            $("#roleEditForm").find('#txtName').val(name);

            $('.permissions').prop('checked',false);
            $.each(permissions.split(","), function (i, permission) {
                let checkbox = $("#roleEditForm").find('input[data-permission="' + permission + '"]');
                checkbox.prop('checked',true);
            });

            $("#roleEditForm").attr('action', '/roles/' + id);
            ModalOptions.toggleModal('roleEditModal');

        }
    </script>)
<<<<<<< HEAD
=======
    <script>
        $(".input_tags").select2({
            tags: false,
            tokenSeparators: [',', ' ']
        });
    </script>
@endpush
@push('styles')
    <style>
        /*.select2-container--default .select2-selection--multiple {*/
        /*   height: 12px !important;*/
        /*    min-height: 12px !important;*/
        /*}*/

        .select2-container--default .select2-selection--single, .select2-container--default .select2-selection--multiple {
            border: 1px solid #e0e3e4 !important;
            border-radius: 0 !important;
        }
    </style>
>>>>>>> 5a30cd9e87500e6db79439b4567c5d6399381e48
@endpush

