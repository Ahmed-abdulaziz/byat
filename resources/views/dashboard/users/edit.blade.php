@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.users')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.users.index') }}"> @lang('site.users')</a></li>
                <li class="active">@lang('site.edit')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.edit')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.users.update', $user->id) }}" method="post" enctype="multipart/form-data">

                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        <div class="form-group">
                            <label>@lang('site.first_name')</label>
                            <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.last_name')</label>
                            <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.email')</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.image')</label>
                            <input type="file" name="image" class="form-control image">
                        </div>

                        <div class="form-group">
                            <img src="{{ $user->image_path }}" style="width: 100px" class="img-thumbnail image-preview" alt="">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.permissions')</label>
                                
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkAll">
                                    <label class="custom-control-label">@lang('site.All')</label>
                                </div>
                                    <div class="nav-tabs-custom">
                                            <div class="row">
                                                @foreach($permissions as $item)
                                         
                                                    <div class="col-md-3">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" {{ $user->hasPermission($item->name) ? 'checked' : '' }}  name="permissions[]" value="{{$item->name}}" id="defaultUnchecked">
                                                                <label class="custom-control-label" for="defaultUnchecked">{{$item->display_name}}</label>
                                                            </div>
                                                    </div>
                                           
                                                
                                            @endforeach
                                        </div>

                            </div><!-- end of nav tabs -->
                            
                        

                        </div>
                         @if (auth()->user()->hasPermission('update_users'))
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.edit')</button>
                        </div>
                        @endif 
                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
@section('javascript')
    <script>
        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endsection
