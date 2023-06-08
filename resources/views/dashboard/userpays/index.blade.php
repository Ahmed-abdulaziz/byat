@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.Client Payment Reports')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.Client Payment Reports')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.Client Payment Reports') <small>{{ $payments->total() }}</small></h3>

                    <form action="{{ route('dashboard.userpays.index') }}" method="get">

                        <div class="row">
                            <div class="col-md-4">
                            @if(isset($allusers))

                                <select class="form-control select2" style="width: 100%;height:100%" name="user_name">
                                    <option selected="selected" value="0">@lang('site.all users')</option>
                                    @foreach($allusers as $single)
                                        <option value="{{$single->name}}">{{$single->name}}</option>
                                    @endforeach
                                </select>
                            @endif
                            </div>
                            <div class="col-md-4">
                                <input type="date" name="start_date">
                                <input type="date" name="end_date">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                            </div>

                        </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                <div class="box-body">

                    @if ($payments->count() > 0)

                        <table class="table table-hover" id="data-table">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.Clint Name')</th>
                                <th>@lang('site.package_name')</th>
                                <th>@lang('site.Total')</th>
                                <th>@lang('site.payment method')</th>
                                <th>@lang('site.payment created at')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($payments as $index=>$user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->user_name }}</td>
                                    <td>{{ $user->package_name}}</td>
                                    <td>{{ $user->total }} </td>
                                    @if($user->payment_type==1)
                                    <td>@lang('site.cache')</td>
                                    @else
                                        <td>@lang('site.Elctronic Payment')</td>
                                    @endif
                                    <td>{{ $user->created_at }}</td>
                                </tr>

                            @endforeach

                            </tbody>
                            <tr>
                                <td rowspan="3">@lang('site.Total') : {{$paymenttotal}} <td>
                            </tr>
                        </table><!-- end of table -->

                        {{ $payments->appends(request()->query())->links() }}

                    @else

                        <h2>@lang('site.no_data_found')</h2>

                    @endif

                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script> -->
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#data-table").DataTable({
                dom: "Blfrtip",

                buttons: [
                    {
                        extend: "print",
                        text: '<i class="fa fa-print"></i>',

                        className: "btn btn-primary btn-xs",

                        exportOptions: {
                            columns: ":visible",
                        },
                    },
                    // {
                    //   extend: "csv",
                    //   className: "btn btn-success btn-xs",
                    //   exportOptions: {
                    //     columns: ":visible",
                    //   },
                    // },
                    {
                        extend: "excel",
                        text: '<i class="fa fa-file-excel-o"></i>',
                        className: "btn btn-success btn-xs",
                        exportOptions: {
                            columns: ":visible",
                        },
                    },

                    {
                        extend: "colvis",
                        text: '<i class="fa fa-eye"></i>',
                        className: "btn btn-info btn-xs",
                        exportOptions: {
                            columns: ":visible",
                        },
                    },
                ],
            });
        });
    </script>

@endsection
