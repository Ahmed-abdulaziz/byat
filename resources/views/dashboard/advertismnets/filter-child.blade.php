                            
                            @foreach($filters as $item)
                              @php
                                    $componants = \App\category_item_components::where('category_item_id' , $item->id)->where('parent_category_components' ,$componant)->get();
                            @endphp
                            @if($componants->count() > 0)
                                <div class="row">
                                     <input type="hidden" name="filters_id[]" value="{{$item->id}}" class="form-control" />
                                      <input type="hidden" name="types[]" value="{{$item->type}}" class="form-control" />
                                     <!--//single select-->
                                    @if($item->type == 1)          
                                  
                                        
                                               <div class="col-md-6  form-group">
                                                    <label>{{$item->name}}</label>
                                                    <select class="form-control select2 " style="width: 100%;height:110% " required name="sub_filter_id[]">
                                                        @foreach($componants as $single)
                                                                <option  value="{{$single->id}}">{{$single->name}}</option>
                                                     
                                                        @endforeach
                                                    </select>
                                            </div>
                                             <div class="col-md-6 filterchild-{{$item->id}}">
                                                 
                                                </div>
                                    
                                    
                                        @endif
                                          </div>
                                  @endif
                              
                            @endforeach