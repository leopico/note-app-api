<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Models\Category;
use App\Models\LikeNote;
use Illuminate\Http\Request;
use App\Models\ContributeNote;
use Illuminate\Support\Facades\Validator;

class NoteApi extends Controller
{
    private function user()
    {
        return Auth()->guard('api')->user();
    }

    public function index()
    {
        $note = Note::where('user_id', $this->user()->id)->latest();
        if ($slug = request()->category_slug) {
            //check slug
            if ($category = Category::where('slug', $slug)->first()) {
                $note->where('category_id', $category->id);
            } else {
                return $this->error('slug_not_found');
            }
        }
        $note = $note->paginate(6);
        $note->appends(request()->all());
        return $this->success($note);
    }
    public function show($id)
    {
        $note = Note::where('slug', $id)->where('user_id', $this->user()->id)
            ->with('category', 'user')
            ->first();
        if (!$note) {
            return $this->error('note_not_see');
        }
        return $this->success($note);
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'title' => "required",
            'color' => "required",
            'category_slug' => "required",
            'description' => "required",
        ]);
        if ($v->fails()) {
            return $this->error($v->errors());
        }

        //check category
        $category = Category::where('slug', $request->category_slug)->where('user_id', $this->user()->id);
        if (!$category->first()) {
            $v->errors()->add('category_slug', 'Category Not Found');
            return $this->error($v->errors());
        }

        Note::create([
            'slug' => uniqid() . $request->title,
            'user_id' => $this->user()->id,
            'category_id' => $category->first()->id,
            'title' => $request->title,
            'color' => $request->color,
            'description' => $request->description,
        ]);
        return $this->success('success');
    }

    public function update(Request $request, $id)
    {
        $v = Validator::make($request->all(), [
            'title' => "required",
            'color' => "required",
            'category_slug' => "required",
            'description' => "required",
        ]);
        if ($v->fails()) {
            return $this->error($v->errors());
        }

        //check category
        $category = Category::where('slug', $request->category_slug)->where('user_id', $this->user()->id);
        if (!$category->first()) {
            $v->errors()->add('category_slug', 'Category Not Found');
            return $this->error($v->errors());
        }
        $note = Note::where('user_id', $this->user()->id)->where('slug', $id);
        if (!$note->first()) {
            $v->errors()->add('title', 'Note Not Found');
            return $this->error($v->errors());
        }

        $note_id = $note->first()->id;
        $note->update([
            'slug' => uniqid() . $request->title,
            'user_id' => $this->user()->id,
            'category_id' => $category->first()->id,
            'title' => $request->title,
            'color' => $request->color,
            'description' => $request->description,
        ]);

        $note = Note::find($note_id);
        return $this->success($note);
    }


    public function destroy($id)
    {
        $note = Note::where('user_id', $this->user()->id)->where('slug', $id);
        if (!$note->first()) {
            return $this->error('wrong_slug');
        }
        $note->delete();
        return $this->success('success');
    }

    //add favoriate
    public function addFav(Request $request)
    {
        $user_id  = $this->user()->id;
        $note_slug = $request->note_slug;

        //check note
        $note = Note::where('slug', $note_slug)->first();
        if (!$note) {
            return $this->error('wrong_slug');
        }

        //save to fav
        $note = LikeNote::create([
            'user_id' => $user_id,
            'note_id' => $note->id
        ]);
        return $this->success('success');
    }

    //remove favoriate
    public function removeFav(Request $request)
    {
        $user_id  = $this->user()->id;
        $note_slug = $request->note_slug;

        //check note
        $note = Note::where('slug', $note_slug)->first();
        if (!$note) {
            return $this->error('wrong_slug');
        }

        //remove to fav
        LikeNote::where('user_id', $user_id)
            ->where('note_id', $note->id)->delete();

        return $this->success('success');
    }

    public function getFav()
    {
        $user_id = $this->user()->id;
        $note = LikeNote::where('user_id', $user_id)->with('note')->paginate(6);
        return $this->success($note);
    }

    //add favoriate
    public function createContribute(Request $request)
    {
        $user_id  = $this->user()->id;
        $note_slug = $request->note_slug;

        //check note
        $note = Note::where('slug', $note_slug)->first();
        if (!$note) {
            return $this->error('wrong_slug');
        }

        //check email
        $user = User::where('email', $request->user_email)->first();
        if (!$user) {
            return $this->error('wrong_email');
        }

        //user ကသူကိုယ်တိုင် contribute လုပ်နေသလား
        if ($user_id == $user->id) {
            return $this->error('your_own_note');
        }

        //check already contribute
        $isContributed = ContributeNote::where('note_id', $note->id)
            ->where('contributed_id', $user->id)->first();
        if ($isContributed) {
            return $this->error('already_contribute');
        }

        //save to fav
        $note = ContributeNote::create([
            'contributer_id' => $user_id,
            'contributed_id' => $user->id,
            'note_id' => $note->id
        ]);
        return $this->success('success');
    }

    public function getContribute()
    {
        $user_id = $this->user()->id;
        $note = ContributeNote::where('contributer_id', $user_id)->with('note', 'contributeUser', 'receiveUser')->paginate(6);
        return $this->success($note);
    }
    public function getReceiveNote()
    {
        $user_id = $this->user()->id;
        $note = ContributeNote::where('contributed_id', $user_id)->with('note', 'contributeUser', 'receiveUser')->paginate(6);
        return $this->success($note);
    }

    public function searchUser(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            return $this->success($user);
        }
        return $this->error('email_not_found');
    }
}
