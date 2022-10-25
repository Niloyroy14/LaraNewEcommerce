<?php

namespace App\Repositories;
use App\Models\Category;
use Image;
use File;

 class CategoryRepository implements CategoryInterface{

    public function index(){
        return Category::orderBy('id', 'desc')->get();
    }

    public function store(array $data){
       
        Category::insert([
            'name'=> $data['name'],
            'description' => $data['description'],
            'parent_id'  =>$data['parent_id'],
            'image' => $data['image'],
        ]);
         //return Category::create($data);
    }

    public function show($id){
          
    }

    public function edit($id){
       return Category::find($id);
    }

    public function update(array $data, $id){
         
     $category = Category::find($id);

        $category->name=$data['category_name'];
        $category->description=$data['description'];
        $category->parent_id=  $data['parent_id'];


        //insert image
        if($data['category_image']){

            //delete the old image from the folder
            if(File::exists('images/category/'.$category->image)){
              File::delete('images/category/'.$category->image);
            }

            $image = $data['category_image'];
            $img = time() . '.'. $image->getClientOriginalExtension();
            $location = 'images/category/' .$img;
            Image::make($image)->save($location);
            $category->image= $img;
        }

        $category->save();
    }

    public function delete($id){
        $category = Category::find($id);
    if (!is_null($category)) {
        if ($category->parent_id == NULL) {
            //delete the sub category
            $subcategory = Category::orderBy('name', 'desc')->where('parent_id', $category->id)->get();

            foreach ($subcategory as $sub) {
                // delete the sub category image
                if (File::exists('images/category/' . $sub->image)) {
                    File::delete('images/category/' . $sub->image);
                }
                $sub->delete();
            }
        }

        //delete the category image

        if (File::exists('images/category/' . $category->image)) {
            File::delete('images/category/' . $category->image);
        }

        $category->delete();
      }
    }

 }