@extends('layouts.dashboard.app')

@section('content')
<script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js"></script>
    <script src="https://raw.githack.com/SortableJS/Sortable/master/Sortable.js"></script>
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
                            <h3 class="box-title">
                                   @if(app()->getLocale()=='ar')
                                        ترتيب 
                                   @else
                                        Ordering
                                   @endif
                            </h3>
                        </div>
                        @include('partials._errors')
                        <form role="form" action="{{route('dashboard.storeorder_filters',$cat_id)}}" method="post" >
                            {{ csrf_field() }}
                            
                            <div id="sortTrue" class="box-body">
                                @php
                                $i=1;
                                @endphp
                                @foreach($data as $item)
                                   
                                    <div class="list-group-item h3">
                                          <span class="qno">{{$i}}</span> {{$item->name}}
                                          <input type="text" hidden value="{{$item->id}}" name="ids[]">
                                        
                                       
                                    </div>
                                @php
                                $i++;
                                @endphp
                                @endforeach

                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">@lang('site.Save')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
@section('javascript')
   
        <script>
                //Get the modal
                var modal = document.getElementById("myModal");
                
                // Get the image and insert it inside the modal - use its "alt" text as a caption
                var img = document.getElementById("myImg");
                var modalImg = document.getElementById("img01");
                var captionText = document.getElementById("caption");
                
                
                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close")[0];
                
                // When the user clicks on <span> (x), close the modal
                span.onclick = function() { 
                  modal.style.display = "none";
                }
                
                $( ".myImg" ).click(function() {
                    modal.style.display = "block";
                  modalImg.src = this.src;
                  captionText.innerHTML = this.alt;
                });
        </script>
        <script>
                  // sort: true
                Sortable.create(sortTrue, {
                  group: "sorting",
                  sort: true
                });
                
                
                function numbering(){
                    var i=1;
                    $('.qno').each(function(){
                    $(this).text(i+'.').append("<span>&nbsp;&nbsp;");
                        i++;
                    });
                  
                }
        
        setInterval(function(){ numbering(); }, 500);
</script>
@endsection

