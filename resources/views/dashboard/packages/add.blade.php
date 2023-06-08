@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>
                <small></small>
            </h1>

            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</li>
            </ol>
        </section>

        <section class="content">

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('site.Packages')</h3>
                        </div>
                        @include('partials._errors')
                        <form role="form" action="{{route('dashboard.packages.store')}}"  method="post"  enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">

                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.Arabic Name')</label>
                                    <input type="text" name="name_ar" class="form-control" required id="" placeholder="@lang('site.Arabic Name')">
                                </div>
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.English Name')</label>
                                    <input type="text" name="name_en" class="form-control" required id="" placeholder="@lang('site.English Name')">
                                </div>
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.color')</label>
                                    <input type="color" name="color" class="form-control" required id="" placeholder="@lang('site.color')">
                                </div>
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.description')</label>
                                    <textarea name="details" class="form-control" required placeholder="@lang('site.description')"></textarea>
                                </div>

                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.image')</label>
                                    <input type="file" name="img" class="form-control" required id="" placeholder="@lang('site.image')">
                                </div>


                                <div class="col-md-8 form-group">
                                    <label>@lang('site.type')</label>
                                    <select class="form-control" name="type" id="typeID" required style="height: 40px">
                                        <option value="0">@lang('site.User packages')</option>
                                        <option value="1">@lang('site.auctions packages')</option>
                                        <option value="2">@lang('site.Technician packages')</option>
                                    </select>
                                </div>

                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.price')</label>
                                    <input type="text" name="price" class="form-control" required id="" placeholder="@lang('site.price')">
                                </div>
                                <div class="col-md-8 form-group" id="advNum">
                                    <label for="">@lang('site.Number')</label>
                                    <input type="text" name="adv_num" class="form-control" value="0" placeholder="@lang('site.advnum')">
                                </div>

                                <div class="col-md-8 form-group period">
                                    <label for="">@lang('site.Period in Days')</label>
                                    <input type="text" name="period" class="form-control" id="" placeholder="@lang('site.Period in Days')">
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">@lang('site.Save')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

    <script>

        $(document).ready(function (){
            $(".period").hide();
            $('#typeID').on('change',function (e){
                e.preventDefault()
                 var x=$(this).val();
                console.log(x);
                 if (x==2){
                     $('#advNum').addClass('hidden');
                        $(".period").show();
                 }else{
                     $('#advNum').removeClass('hidden');
                      $(".period").hide();
                 }
            });




        });


    </script>


@endsection
