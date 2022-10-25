<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Brand;
use Image;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $brand = Brand::all();
            if ($brand->count()>0) {
                return $this->responseWithSuccess('All Brand List', $brand);
            }
        } catch (\Exception $e) {
            return $this->responseWithError($e->getMessage());
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:150',
            'brandimage' => 'nullable|image',
        ];

        $response = $this->validateWithJson($request->all(), $rules);

        if($response===true){

            try{

                $brand = new Brand();
                $brand->name = $request->name;
                $brand->description = $request->description;

                //insert image
                if ($request->hasfile('brandimage')) {
                    //insert the image
                    $image = $request->file('brandimage');
                    $img = time() . '.' . $image->getClientOriginalExtension();
                    $location = 'images/brand/' . $img;
                    Image::make($image)->save($location);
                    $brand->image = $img;
                }
                $brand->save();

                return $this->responseWithSuccess('A new brand created.', $response);

            } catch (\Exception $e) {
                 return $this->responseWithError($e->getMessage());
            }
        }else{
           return $this->responseWithError('Data validatiion failed.', $response);
        }

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
    public function edit($id)
    {
        try {
            $brand = Brand::find($id);
            if ($brand->count() > 0) {
                return $this->responseWithSuccess('Brand Found', $brand);
            }
        } catch (\Exception $e) {
            return $this->responseWithError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:150',
            'brandimage' => 'nullable|image',
        ];

        $response = $this->validateWithJson($request->all(), $rules);

        if ($response === true) {

            try {

                $brand = Brand::find($id);

                $brand->name = $request->brand_name;
                $brand->description = $request->description;


                //insert image
                if ($request->brand_image) {

                    //delete the old image from the folder
                    if (File::exists('images/brand/' . $brand->image)) {
                        File::delete('images/brand/' . $brand->image);
                    }

                    $image = $request->file('brand_image');
                    $img = time() . '.' . $image->getClientOriginalExtension();
                    $location = 'images/brand/' . $img;
                    Image::make($image)->save($location);
                    $brand->image = $img;
                }

                $brand->save();

                return $this->responseWithSuccess('A brand updated successfully.', $response);
            } catch (\Exception $e) {
                return $this->responseWithError($e->getMessage());
            }
        } else {
            return $this->responseWithError('Data validatiion failed.', $response);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $brand = Brand::find($id);
            if (!is_null($brand)) {
                //delete the brand image
                if (File::exists('images/brand/' . $brand->image)) {
                    File::delete('images/brand/' . $brand->image);
                }

                $brand->delete();
                return $this->responseWithSuccess('Brand Deleted Succesfully');

            }
            
        } catch (\Exception $e) {
            return $this->responseWithError($e->getMessage());
        }
    }


    




}
