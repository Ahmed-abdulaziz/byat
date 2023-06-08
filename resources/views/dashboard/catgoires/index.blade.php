@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.Catgoires')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.Catgoires')</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.Catgoires') <small></small></h3>


                    <form action="{{route('dashboard.catgoiries.index')}}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                               @if(auth()->user()->hasPermission('create_categories'))
                                <a href="{{route('dashboard.catgoiries.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.Add new Category')</a>
                                @endif
                                @php
                                      $check = \App\Models\Catgories::where('parent_id', request()->get('type'))->count();
                                @endphp
                                  @if(auth()->user()->hasPermission('arrange_categories'))
                                         @if($check > 0)
                                             <a href="{{route('dashboard.subcatgoiries',request()->get('type'))}}" class="btn btn-primary"><i class="fa fa-arrows-v" aria-hidden="true"></i> @lang('site.arrange Categorys')</a>
                                         @endif
                                  @endif
                            </div>
                     
                        </div>
                    </form><!-- end of form -->
                </div> <!-- end of box header -->

                <div class="box-body">
                    @if($allCatgories->count() > 0)
                        <table class="table table-bordered">
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.catgory Type')</th>
                                <th>@lang('site.Main Category')</th>
                                <th>@lang('site.Options')</th>
                            </tr>


                            @foreach($allCatgories as $index=>$single)
                           
                                <tr>
                                    <td>{{$index +1}}</td>
                                    @if(app()->getLocale()=='ar')
                                        <td>{{$single->name_ar ?? ""}}</td>
                                    @else
                                        <td>{{$single->name_en ?? ""}}</td>
                                    @endif
                                    @if($single->parent_id==null)
                                        <td>@lang('site.Main Catgory')</td>
                                    @else
                                        <td>@lang('site.Sub Catgory')</td>
                                    @endif
                                    @if($single->parent_id==null)
                                        <td>@lang('site.No data')</td>
                                    @else
                                        @if(app()->getLocale()=='ar')
                                            <td>{{$single->parent->name_ar ?? ""}} </td>
                                        @else
                                            <td>{{$single->parent->name_en ?? ""}} </td>
                                        @endif
                                    @endif

                                    <td>   
                                             
                                        @if(isset($single->id))
                                         @if($single->parent_id==1 || $single->parent_id==2)
                                                @if(auth()->user()->hasPermission('read_filters'))
                                                        <a href="{{route('dashboard.filters',$single->id)}}" class="btn btn-primary">@lang('site.filter')</a>
                                                        @endif
                                                         @if(auth()->user()->hasPermission('read_banars'))
                                                             <a href="{{ route('dashboard.banar.index',['cat_id'=> $single->id ]) }}" class="btn btn-primary"><i class="fa fa-th"></i> <span> @lang('site.Banars')</span></a>
                                                        @endif
                                                 @endif
                                          @endif
                                      
                                         @php
                                         
                                        $check = \App\Models\Catgories::where('parent_id', $single->id)->count();
                                         @endphp
                                      @if($check > 0)
                                         <a href="{{route('dashboard.catgoiries.index',['type'=>$single->id])}}" class="btn btn-primary"><i class="fa fa-braille" aria-hidden="true"></i>@lang('site.branches')</a>
                                        @endif
                                        @if (auth()->user()->hasPermission('update_categories'))
                                            <a href="{{route('dashboard.catgoiries.edit',$single->id)}}" class="btn btn-primary"><i class="fa fa-edit"></i>@lang('site.update')</a>
                                        @else
                                            <a  class="btn btn-primary disabled"><i class="fa fa-edit"></i>@lang('site.update')</a>
                                        @endif
                                            @if (auth()->user()->hasPermission('hide_categories'))
                                                  @if(empty($single->deleted_at))
                                                  <a href="{{route('dashboard.hide_show',[$single->id , 0])}}" class="btn btn-primary"><i class="fa fa-eye-slash" aria-hidden="true"></i> @lang('site.hide')</a>
                                                   @else
                                                    <a href="{{route('dashboard.hide_show',[$single->id , 1])}}" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i> @lang('site.show')</a>
                                                  @endif
                                               @endif        
                                        <form action="{{ route('dashboard.catgoiries.destroy', $single->id) }}" method="post" style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            @if(auth()->user()->hasPermission('delete_categories'))
                                                @if($single->id==1 || $single->id==2)
                                                      <a  class="btn btn-primary disabled"><i class="fa fa-edit"></i>@lang('site.Cannot Deleted')</a>
                                                @else
                                                    <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                @endif

                                             @else

                                                <button type="submit" class="btn btn-danger delete btn-sm disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                            @endif
                                        </form>

                                    </td>
                                </tr>
                            @endforeach

                        </table>
                        {{ $allCatgories->appends(request()->query())->links() }}
                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>

            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
