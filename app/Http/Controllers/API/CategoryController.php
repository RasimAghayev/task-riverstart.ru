<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\API\Category;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Category as CategoryResource;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Category::count()>0) {
            $categories = Category::all();

            return $this->sendResponse(CategoryResource::collection($categories), 'Categories Retrieved Successfully.');
        }
        return $this->sendResponse([], 'Empty data.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): \Illuminate\Http\Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $category = Category::create($input);

        return $this->sendResponse(new CategoryResource($category), 'Category Created Successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\API\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $category = Category::find($category->id);
        if (is_null($category)) {
            return $this->sendError('Category not found.');
        }

        return $this->sendResponse(new CategoryResource($category->allChildren), 'Category Retrieved Successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\API\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\API\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $category = Category::find($category->id);
        $category->name = $input['name'];
        $category->detail = $input['description'];
        $category->parent_id = $input['parent_id'];
        $category->save();

        return $this->sendResponse(new CategoryResource($category), 'Category Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\API\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category = Category::find($category->id);
        $category->delete();

        return $this->sendResponse([], 'Category Deleted Successfully.');
    }
}
