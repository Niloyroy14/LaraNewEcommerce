@extends('admin.layouts.master')

@section('content')
  <div class="main-panel">
    <div class="content-wrapper">

      <div class="card">
        <div class="card-header">
          Manage Product
        </div>
        <div class="card-body">
          
          @include('admin.partial.messages')

          <table class="table table-hover table-striped" id="dataTable">
            <thead>           
            <tr>
              <th>#</th>
              <th>Product Code</th>
              <th>Product Title</th>
              <th>Image</th>
              <th>Price</th>
              <th>Quantity </th>
              <th> Action </th>
            </tr>
            </thead>
            
            <tbody>  

          @foreach($products as $product) 
            <tr>
              <td>#</td>
              <td>PLE{{$product->id}} </td>
              <td>{{$product->title}} </td>
             
              <td>
                 @php $i=1; @endphp
                 @foreach($product->images as $image)
                 @if($i > 0) 
                    <img src="{{asset('images/product/'.$image->image)}}" width="100">
                 @endif
                 @php $i--; @endphp
                 @endforeach
              </td>
              
              <td>{{$product->price}} </td>
              <td>{{$product->quantity}} </td>  
              <td>
                  <div class="btn-group">
                    <button type="button" class="btn btn-success">Action</button>
                    <button type="button" class="btn btn-success dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu" style="background-color:#007bff;">
                        <a class="dropdown-item" href="{{ route('admin.product.edit', $product->id) }}">
                            <i class="fas fa-pencil-alt"></i> &nbsp; Edit
                        </a>
                        <a  data-toggle="modal"  class="dropdown-item" href="#deleteModal{{$product->id}}">
                            <i class="fas fa-trash"></i> &nbsp; Delete
                        </a>
                        <a class="dropdown-item" href="{{route('admin.product_image.create', $product->id)}}">
                            <i class="fas fa-book"></i> &nbsp; Upload Image
                        </a>
                    </div>
                </div>

                

                <!-- Modal -->
                 <div class="modal fade" id="deleteModal{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                       <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLabel">Are You Sure To Delete</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                         </button>
                       </div>
                        <div class="modal-body">
                          <form action="{{route('admin.product.delete',$product->id)}}"  metod="POST">
                              {{ csrf_field() }}
                              <button type="submit" class="btn btn-danger">Permanent Delete</button>
                         </form>
                       </div>
                       <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                       </div>
                     </div>
                   </div>
                 </div>

               </td>
          
            </tr>

            @endforeach

            </tbody>

          <tfoot>
            <tr>
              <th>#</th>
              <th>Product Code</th>
              <th>Product Title</th>
              <th>Image</th>
              <th>Price</th>
              <th>Quantity </th>
              <th> Action </th>
            </tr>
           </tfoot>

          </table>
        </div>
      </div>

    </div>
  </div>
  <!-- main-panel ends -->
@endsection
