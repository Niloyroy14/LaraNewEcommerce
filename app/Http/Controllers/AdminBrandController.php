<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Image;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;

class AdminBrandController extends Controller
{

  /*  public function __construct()
    {
        $this->middleware('auth:admin');
    }
*/
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function manage_brand()
     {
        // $brands = Brand::orderBy('id','desc')->get();
        // return view('admin.pages.brand.index')->with('brand',$brands);

      

        if (request()->ajax()) {

            return datatables()->of(Brand::all())
               ->setRowClass(function ($brand) {
                    return $brand->id % 2 == 0 ? 'alert-success' : 'alert-warning';
                })->setRowAttr([
                    'align' => 'center',
                ])->setRowData([
                    'data-id' => 'row-{{$id}}',
                ])

                ->addColumn('image', function ($brand) {
                    $url = asset("images/brand/$brand->image");
                    return '<img src=' . $url . ' border="0" width="40" class="img-rounded" align="center" />';
                })

                ->addColumn('action', function ($brand) {
                    return '<a href="/admin/brand/edit/' . $brand->id . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                   <a href="/admin/brand/delete/' . $brand->id . '" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                })

                ->rawColumns(['image', 'action'])
                ->editColumn('created_at', function ( $brand) {
                    return  $brand->created_at->diffForHumans();
                })
               
                ->make(true);
        }
          return view('admin.pages.brand.datatable');
      }


    // public function anyData()
    // {
    //     return Datatables::of(Brand::query())->make(true);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_brand()
    {
        return view('admin.pages.brand.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function brand_store(Request $request)
    {



        $request->validate([

            'name' => 'required|max:150',
            'brandimage' => 'nullable|image',
             ],
             
             [
              'name.required'=>'please provide a brand name',
              'brandimage.image'=>'plaese provide a valid image with .png,.jpg,.gif extension',
             ]

         );


    $brand = new Brand();

    $brand->name=$request->name;
    $brand->description=$request->description;
   

//insert image
     if($request->hasfile('brandimage')){
        //insert the image
         $image = $request->file('brandimage');
         $img = time() . '.'. $image->getClientOriginalExtension();
         $location = 'images/brand/' .$img;
         Image::make($image)->save($location);
         $brand->image= $img;
    }
       $brand->save();




    
    session()->flash('success','A New Brand Has Added Succesfully!!!');

    return redirect()->route('admin.brand');


        
    }

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function brand_edit($id)
    {
         $brand = Brand::find($id);
        return view('admin.pages.brand.edit')->with('brand',$brand);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function brand_update(Request $request, $id)
    {
        
    $request->validate([
    'brand_name' => 'required|max:150',
    'brand_image' => 'nullable|image',
     ],
     [
      'brand_name.required'=>'please provide a brand name',
      'brand_image.image'=>'plaese provide a valid image with .png,.jpg,.gif extension',
     ]);


    $brand = Brand::find($id);

    $brand->name=$request->brand_name;
    $brand->description=$request->description;
    
       

    //insert image
     if($request->brand_image){
        
        //delete the old image from the folder
        if(File::exists('images/brand/'.$brand->image)){
           File::delete('images/brand/'.$brand->image);
        }

         $image = $request->file('brand_image');
         $img = time() . '.'. $image->getClientOriginalExtension();
         $location = 'images/brand/' .$img;
         Image::make($image)->save($location);
         $brand->image= $img;
    }
    
       $brand->save();

      
       session()->flash('success','A New Brand Has Updated Succesfully!!!');

       return redirect()->route('admin.brand');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function brand_delete($id)
    {
        
          $brand =Brand::find($id);
          
          if(!is_null($brand)){ 

          //delete the brand image
         
         if(File::exists('images/brand/'.$brand->image)){
            File::delete('images/brand/'.$brand->image);
           }

           $brand->delete();
          }

          session()->flash('success','Brand Has Deleted Succesfully!!!');
          
          return back();
    }
}
