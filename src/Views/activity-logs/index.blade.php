@extends('layouts.app')
@section('title','Activity Log')
@section('content')
    <div class="hk-pg-header">
        <h4 class="hk-sec-title">Activity Logs</h4>
        <button type="button" class="btn btn-primary bg-primary-blue" data-toggle="modal"
                data-target="#activityLogFilterModal">
            Filter
        </button>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <table id="activityLogTable" class="table table-hover w-100 display">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Subject</th>
                                    <th>Subject type</th>
                                    <th>Causer</th>
                                    <th>Causer type</th>
                                    <th>Created at</th>
                                    <th>Properties</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="modal fade " id="activityLogFilterModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title">Filter Now</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body mt-3 mb-3">
                    {!! Form::open(['method' => 'post','url'=>'/activity-logs/search/data', 'id' => 'activityLogForm']) !!}
                    @include('Administration::activity-logs.form')
                    <div class="float-right">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button
                            onclick="process_form()"
                            type="button" class="btn btn btn-outline-primary-blue">Filter
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    @include('layouts.includes.styles.form')
    <link href="{{asset('plugins/datatables/jquery.dataTables.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('plugins/daterangepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .terminal-container{
            min-height: 200px;
            width:500px;
            color: white;
            background-color: #0d1113;
            font-family: "Lucida Console";
        }
    </style>
@endpush

@push('scripts')
    @include('layouts.includes.scripts.form')
    <!-- Data Table JavaScript -->
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTables-data.js')}}"></script>
    <script src="{{asset('plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{asset('plugins/jquery-validation/additional-methods.min.js')}}"></script>


    <script>
        DataTableOption.initDataTable('activityLogTable', 'activity-logs/table/data', [7, 'desc']);
        let rules = {
            'dateRange': {
                require_from_group: [1,'.validate_group']
            },
            'performed_on': {
                require_from_group: [1,'.validate_group']
            },
            'caused_by': {
                require_from_group: [1,'.validate_group']
            },
            'activity': {
                require_from_group: [1,'.validate_group']
            }
        };
        FormOptions.initValidation('activityLogForm',rules);
        $('.date_input').daterangepicker({
            showDropdowns: true,
            timePicker: true,
            startDate: moment().startOf('hour'),
            timePicker24Hour: true,
            locale: {
                format: 'Y-M-DD hh:mm'
            }
        });

        $('.date_input').val('');

        function process_form() {
            if($('#activityLogForm').valid()){
                let date_range = $("#dateRange").val();
                let performed_on = $("#performed_on").val();
                let caused_by = $("#caused_by").val();
                let log_activity = $("#activity").val();
                let table = $('#activityLogTable').DataTable();
                table.ajax.url('/activity-logs/table/data?performed_on=' + performed_on + '&caused_by=' + caused_by + '&date_range=' + date_range + '&log_activity=' + log_activity + '&filter=' + true).load();
                $("#activityLogFilterModal").modal('toggle');
            }
        }
    </script>
@endpush
