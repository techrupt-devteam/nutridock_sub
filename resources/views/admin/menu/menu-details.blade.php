<div class="modal-header">
  <h3 class="modal-title">Title : {{ucfirst($data['menu_title'])}}</h3>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <div class="row">
                <div class="col-md-8 col-lg-9">
                  <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="name" class="label-control">Category Name : {{ucfirst($category->name)}}</label>
                        
                      </div>
                   </div>
                  <div class="col-md-4">
                      <div class="form-group">
                          <?php 
                              $menu_types  = explode(",",$data['menu_type']);
                          ?>
                         <label for="name" class="label-control">Meal Type</label>
                           <ul>  
                           @foreach($menu_type as $tvalue)
                             @if(in_array($tvalue->meal_type_id,$menu_types))
                              <li>{{$tvalue->meal_type_name}}</li>
                             @endif
                           @endforeach
                           </ul>
                      </div>
                   </div>
                   <div class="col-md-4">
                    <div class="form-group">
                          <?php 
                            $specification_array  = explode(",",$data['specification_id']);
                          ?>
                       <label for="name" class="label-control">Specification</label>
                         <ul>
                         @foreach($specification as $svalue)
                             @if(in_array($svalue->id,$specification_array)) 
                               <li>{{$svalue->specification_title}}</li>
                             @endif
                         @endforeach
                        </ul>

                      
                     </div>
                 </div>
                 <hr/>
                 <div class="col-sm-6">
                  <div class="form-group">
                    <label for="name">Short Description </label>
                    <p class="text-justify">{{$data['menu_description']}}</p>
                  </div>
                 </div>
                 <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Ingredients</label>
                      <p class="text-justify">{{$data['ingredients']}}</p>
                    </div>
                </div>
                </div>
              </div>
                <div class="col-md-4 col-lg-3">
                  <label for="name">Menu Image </label>
                  <div id="image-preview" class="mx-auto" style="background-size:cover;background-image:  url('admin_css_js/css_and_js/admin/dist/img/default-img.jpg'); ">
                    <img id="blah" src="{{ url('/')}}/uploads/menu/{{$data['image']}}"/>
                  </div>
               </div>
               </hr>
               <div class="row">
                <div class="col-md-12">
                  <div class="col-md-3">
                      <div class="form-group">
                        <label for="name">Calories : {{$data['calories']}}</label>
                      </div>
                  </div>
                  
                  <div class="col-md-3">
                      <div class="form-group">
                        <label for="name">Proteins: {{$data['proteins']}}</label>
                      </div>
                  </div>
                  
                  <div class="col-md-3">
                      <div class="form-group">
                        <label for="name">Carbohydrates : {{$data['carbohydrates']}}</label>
                      </div>
                  </div>
                  
                  <div class="col-md-3">
                      <div class="form-group">
                        <label for="name">Fats : {{$data['fats']}}</label>
                      </div>
                  </div>
                </div>
               </div>
          <hr/>
          <div class="row">
             <div class="col-md-12">
              <div class="form-group" style="text-align: justify;margin: 13px;">
                <label for="name" style="margin: 10px!important;">What Makes Dish Special</label>
                  {!!$data['what_makes_dish_special']!!}
                </div>
              </div>            
          </div>
          <hr/> 
          <div class="row">
             <div class="col-md-12">
              <div class="col-md-6">
                <label>Menu  Multiple Image</label>
                <div class="row" style="margin: 0px">
                   @foreach($menu_img as $key => $nmivalue)
                          <div class="col-sm-4" style="padding: 2px">
                            <img src="{{ url('/')}}/uploads/menu/{{$nmivalue->img_path}}" class="img-responsive"  style="height: 136px; object-fit: cover;border-radius: 3px;border: 2px solid;">
                             </div>
                          @endforeach
                </div>
             </div>
             <div class="col-md-6">
               <label>Menu Ingrediant Name & Images</label>
               <div class="row" style="margin: 0px">
                @foreach($ingrediants as $ikey => $ingvalue)
                 <div class="col-sm-4" style="padding: 2px">
                   <img src="{{ url('/')}}/uploads/menu/menu_ingrediants/{{$ingvalue['image']}}" class="img-responsive" style="height: 136px; object-fit: cover;border-radius: 3px;border: 2px solid;">
                    
                   <div style="text-align: center;color: green;font-size: 15px;font-weight: 700;text-overflow: ellipsis;word-break: break-word;">{{ucfirst($ingvalue['name'])}}</div>
                 </div>
                  @endforeach
               </div>

              
             </div> 

             </div>
          </div>  

</div>





