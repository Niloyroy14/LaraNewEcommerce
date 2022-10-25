@extends('admin.layouts.master')

@section('content')
  <div class="main-panel">
    <div class="content-wrapper">

      <div class="card mt-5">
        <div class="card-header">
          <a  class="float-right"  href="{{route('admin.product.create')}}"> Add Product</a>
        </div>
        <div class="card-body">
                <input type="hidden" id="product_id" value="{{@$product_id}}">
               <label for="input_res">Add Product Image</label>
                <div class="file-loading">
                     <input id="product_image" type="file" name="product_image" multiple>
                </div>

        </div>
      </div>

    </div>
  </div>
  <!-- main-panel ends -->
@endsection


@section('scripts')

<script>

  $(document).ready(function() {

    var id = $("#product_id").val();

    $("#product_image").fileinput({
            theme: 'fa',
            uploadUrl: "{{url('/admin/product_image/store')}}" + '/' + id,
            uploadExtraData: function() {
                return {
                  _token: $("input[name='_token']").val(),
                };
            },
            allowedFileExtensions: ['jpg', 'jpeg', 'png', 'gif'],
            overwriteInitial: false,
            initialPreview: [
               @foreach(App\Models\ProductImage::where('product_id',$product_id)->get() as $image)
                 @if( ($image!=null) && ($image!=''))
                   `<img src="{{asset('images/product/'.$image->image)}}"  class="kv-preview-data file-preview-image">`,
                 @endif
               @endforeach
            ],

            initialPreviewAsData: false, // allows you to set a raw markup
            initialPreviewFileType: 'image', // image is the default and can be overridden in config below
             initialPreviewDownloadUrl: 'https://picsum.photos/id/{key}/1920/1080', // includes the dynamic key tag to be replaced for each config
              initialPreviewConfig: [
                @foreach(App\Models\ProductImage::where('product_id',$product_id)->get() as $image)
                 
                  {type: "image", caption: "{{$image->image}}", description: "<h5>Number One</h5> This is a representative placeholder description # 1 for this image.", size: 847000, url: "{{url('/admin/product_image/delete')}}"+'/'+'{{$image->id}}', key: {{$image->id}}},
                @endforeach
              ],
         

            maxFileSize:3000,
            maxFilesNum: 5,
           
            // deleteUrl: "{{url('/admin/product_image/delete')}}" + '/' + id,

            deleteExtraData: function() {
                    return {
                            _token: $("input[name='_token']").val(),
                        };
                    },
           
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }
          
        });

       
        

        $("#product_image").on("filepredelete", function(jqXHR) {
          var abort = true;
          if (confirm("Are you sure you want to delete this image?")) {
              abort = false;
          }
       
        return abort; // you can also send any data/object that you can receive on `filecustomerror` event
       });



      });
 

// $(document).ready(function() {
//     $("#product_image").fileinput({
//         uploadUrl: "{{url('/admin/product_image/store')}}" + '/' + id,
//         uploadAsync: false,
//         maxFileCount: 5,
//         overwriteInitial: false,
//         deleteUrl: "{{url('/admin/product_image/delete')}}" + '/' + id,
//         initialPreview: [
//         // IMAGE RAW MARKUP
//         '<img src="https://picsum.photos/id/239/1920/1080" class="kv-preview-data file-preview-image">',
//         // IMAGE RAW MARKUP
//         '<img src="https://picsum.photos/id/279/1920/1080" class="kv-preview-data file-preview-image">',
//         // TEXT RAW MARKUP
//         '<textarea class="kv-preview-data file-preview-text font-monospace" readonly>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ut mauris ut libero fermentum feugiat eu et dui. Mauris condimentum rhoncus enim, sed semper neque vestibulum id. Nulla semper, turpis ut consequat imperdiet, enim turpis aliquet orci, eget venenatis elit sapien non ante. Aliquam neque ipsum, rhoncus id ipsum et, volutpat tincidunt augue. Maecenas dolor libero, gravida nec est at, commodo tempor massa. Sed id feugiat massa. Pellentesque at est eu ante aliquam viverra ac sed est.</textarea>'
//     ],
//     initialPreviewAsData: false, // allows you to set a raw markup
//     initialPreviewFileType: 'image', // image is the default and can be overridden in config below
//     initialPreviewDownloadUrl: 'https://picsum.photos/id/{key}/1920/1080', // includes the dynamic key tag to be replaced for each config

//         uploadExtraData: {
//           _token: $("input[name='_token']").val(),
//         }
//     });
//     $("#product_image").on("filepredelete", function(jqXHR) {
//         var abort = true;
//         if (confirm("Are you sure you want to delete this image?")) {
//             abort = false;
//         }
       
//         return abort; // you can also send any data/object that you can receive on `filecustomerror` event
//     });
// });




</script>


@endsection
