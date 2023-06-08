@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.Areas')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.Areas')</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.Areas') <small></small></h3>


                    <form action="{{route('dashboard.area.index')}}" method="get">

                        <div class="row">
                            <div class="col-md-8">
                                    @if(isset($citeis))
                                        <label>@lang('site.Choose City')</label>
                                        <select class="form-control select2" style="width: 100%; height: 40px" name="city_id">
                                            <option selected="selected" value="0">@lang('site.Choose City name')</option>
                                            @foreach($citeis as $single)
                                                @if(app()->getLocale()=='ar')
                                                    <option value="{{$single->id}}">{{$single->name_ar}}</option>
                                                @else
                                                    <option value="{{$single->id}}">{{$single->name_en}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                                @if (auth()->user()->hasPermission('create_area'))
                                      <a href="{{route('dashboard.area.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.Add Areas')</a>
                                @endif
                            </div>

                        </div>
                    </form><!-- end of form -->
                </div> <!-- end of box header -->

                <div class="box-body">
                    @if($allareas->count() > 0)
                        <table class="table table-bordered">
                            <tr>
                                <th>#</th>
                                <th>@lang('site.Name')</th>
                                <th>@lang('site.City Name')</th>
                                <th>@lang('site.Options')</th>
                            </tr>


                            @foreach($allareas as $index=>$single)
                                <tr>
                                    <td>{{$index +1}}</td>
                                    @if(app()->getLocale()=='ar')
                                        <td>{{$single->name_ar ?? ''}}</td>
                                    @else
                                        <td>{{$single->name_en ?? ''}}</td>
                                    @endif

                                    @if(app()->getLocale()=='ar')
                                    <td>{{$single->city->name_ar ?? ''}}</td>
                                    @else
                                        <td>{{$single->city->name_en ?? ''}}</td>
                                    @endif
                                        <td>
                                             @if (auth()->user()->hasPermission('update_area'))
                                                    <a href="{{route('dashboard.area.edit',$single->id)}}" class="btn btn-primary"><i class="fa fa-edit"></i>@lang('site.update')</a>
                                            @endif
                                         @if (auth()->user()->hasPermission('delete_area'))
                                                <form action="{{ route('dashboard.area.destroy', $single->id) }}" method="post" style="display: inline-block">
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete') }}
                                                    <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                </form>
                                         @endif

                                    </td>
                                </tr>
                            @endforeach

                        </table>

                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>

            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
