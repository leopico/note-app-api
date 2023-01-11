<?php

namespace App\Http\Controllers;


use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryApi extends Controller
{
    private function user()
    {
        return Auth()->guard('api')->user();
    }

    public function index()
    {
        $category = Category::where('user_id', $this->user()->id)->withCount('note')->latest();
        $category = $category->paginate(5);
        $category->appends(request()->all());
        return $this->success($category);
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => "required"
        ]);
        if ($v->fails()) {
            return $this->error($v->errors());
        }
        $category = Category::create([
            'slug' => uniqid() . $request->name,
            'user_id' => $this->user()->id,
            'name' => $request->name,
        ]);
        return $this->success($category);
    }

    public function update(Request $request, $id)
    {
        $v = Validator::make($request->all(), [
            'name' => "required"
        ]);
        if ($v->fails()) {
            return $this->error($v->errors());
        }

        $category = Category::where('slug', $id)->first();

        if (!$category->first()) {
            return $this->error('wrong_slug');
        }

        $category_id = $category->first()->id;

        $category->update([
            'slug' => uniqid() . Str::slug($request->name),
            'user_id' => $this->user()->id,
            'name' => $request->name,
        ]);

        $category = Category::where('id', $category_id)->first();
        return $this->success($category);
    }


    public function destroy($id)
    {
        $category = Category::where('user_id', $this->user()->id)->where('slug', $id);
        if (!$category->first()) {
            return $this->error('wrong_slug');
        }
        $category->delete();
        return $this->success('success');
    }
}
