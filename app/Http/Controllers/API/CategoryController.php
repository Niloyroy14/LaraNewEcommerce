<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\Repositories\CategoryRepository;
use App\Repositories\CategoryInterface;
use Image;
use File;


class CategoryController extends Controller
{

    // space that we can use the repository from
    protected $category;

    public function __construct(CategoryInterface $category)
    {
        $this->category = $category;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $category = $this->category->index();
            if ($category->count() > 0) {
                return $this->responseWithSuccess('All Category List', $category);
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
        //
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
            'categoryimage' => 'nullable|image',
        ];

        $response = $this->validateWithJson($request->all(), $rules);

        if ($response === true) {

            try {

                $data = $request->all();

                //insert image
                if ($request->hasfile('categoryimage')) {
                    //insert the image
                    $image = $request->file('categoryimage');
                    $img = time() . '.' . $image->getClientOriginalExtension();
                    $location = 'images/category/' . $img;
                    Image::make($image)->save($location);
                    $data['image'] = $img;
                }

                $this->category->store($data);

                return $this->responseWithSuccess('A new brand created.', $response);
            } catch (\Exception $e) {
                return $this->responseWithError($e->getMessage());
            }
        } else {
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
            $cat = $this->category->edit($id);
            if ($cat->count() > 0) {
                return $this->responseWithSuccess('Brand Found', $cat);
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
            'category_name' => 'required|max:150',
            'categoryimage' => 'nullable|image',
        ];

        $response = $this->validateWithJson($request->all(), $rules);
       
        if ($response === true) {

            try {

                $data = $request->all();

                $this->category->update($data, $id);

                return $this->responseWithSuccess('A new category has updated succesfully.',$response);
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
             $this->category->delete($id);
             return $this->responseWithSuccess('Category Has Deleted Succesfully!!!');
        } catch (\Exception $e) {
            return $this->responseWithError($e->getMessage());
        }
    }
}
