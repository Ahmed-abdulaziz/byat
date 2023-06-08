@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.Coupon reports')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.Coupon reports')</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.Coupon reports') <small></small></h3>
                    
                    <form action="{{route('dashboard.Copon-reports')}}" method="get">
                        <div class="row">
                            <div class="col-md-3">
                                <label>@lang('site.Application Users')</label>
                                <select class="select2-class" name="user" required>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>@lang('site.start-date')</label>
                                <input type="date" name="start_date" class="form-control" required />
                            </div>
                            <div class="col-md-3">
                                <label>@lang('site.end_date')</label>
                                <input type="date" name="end_date" class="form-control" required/>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" style="margin-top:24px;" class="btn btn-primary">@lang('site.Filter')</button>
                            </div>
                        </div>
                    </form>

                </div> <!-- end of box header -->

                <div class="box-body">
                    @if(count($data) > 0)
                        <table class="table table-bordered" id="myTable">
                             <thead>
                            <tr>
                                        <th>#</th>
                                        <th>@lang('site.user-name')</th>
                                        <th>@lang('site.code')</th>
                                        <th>@lang('site.code amount')</th>
                                        <th>@lang('site.charge date')</th>
                            </tr>

                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                            @foreach($data as $index=>$single)
                            @php
                                $user  = \App\Models\appUsers::find($single->user_id);
                                $copon = \App\copons::find($single->copon_id);
                                
                                $total += $copon->balance;
                            @endphp
                                <tr>
                                    <td>{{++$index}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$copon->code}}</td>
                                     <td>{{$copon->balance}} kwd</td>
                                    <td>{{$single->created_at}}</td>
                               
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                              <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>@lang('site.Total') :  {{$total}} kwd</th>
                                        <th></th>
                            </tr>
                        </tfoot>
                        </table>
                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>

            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->
  

@endsection
@section('javascript')
<script>
    
   
    $(".select2-class").select2({
        placeholder: "Select a state"
    });

</script>
@endsection
