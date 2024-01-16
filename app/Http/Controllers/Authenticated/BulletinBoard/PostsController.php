<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use Auth;
use App\Http\Requests\MainCategoryFormRequest;//バリデーション処理の為追加
use App\Http\Requests\SubCategoryFormRequest;//バリデーション処理の為追加
use App\Http\Requests\CommentFormRequest;//バリデーション処理の為追加
use App\Http\Requests\PostEditRequest;//バリデーション処理の為追加

class PostsController extends Controller
{
    public function show(Request $request){
        //dd($request);
        //$sub_category_word=$request->sub_category_word;
        //dd($sub_category_word);
        // $keywords=$request->input('subject');
        //  dd($keywords);
        // ▼追加 withメソッドの中にpostモデルにある「subCategoriesメソッド」を追加
        $posts = Post::with('user','postComments','subCategories')->get();
        //dd($posts);
        $categories = MainCategory::get();
        //dd($categories);
        $sub_categories = SubCategory::get();
        //dd($sub_categories);
        $like = new Like;
        $post_comment = new Post;
        if(!empty($request->keyword)){
            $posts = Post::with('user', 'postComments')
            ->where('post_title', 'like', '%'.$request->keyword.'%')
            ->orWhere('post', 'like', '%'.$request->keyword.'%')->get();
            //dd($posts);
        }else if($request->sub_category_word){
            //$sub_category_word = $request->sub_category_word;
            //dd($sub_category_word);
            //▼追加
            $posts = Post::with('user','postComments','subCategories')
            ->whereHas('subCategories',function ($q) use ($request) {$q->where('sub_category', '=', $request->sub_category_word);})->get();
            //dd($posts);
        }else if($request->like_posts){
            $likes = Auth::user()->likePostId()->get('like_post_id');//likeした投稿のIDを抽出
            //dd($likes);
            $posts = Post::with('user', 'postComments')
            ->whereIn('id', $likes)->get();
        }else if($request->my_posts){
            $posts = Post::with('user', 'postComments')
            ->where('user_id', Auth::id())->get();
            // dd($posts);
        }
        return view('authenticated.bulletinboard.posts', compact('posts', 'categories','sub_categories', 'like', 'post_comment'));
    }

    public function postDetail($post_id){
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        //ddd($post);
        // $posts = Post::with('subCategories')->find($post_id);
        //dd($posts);
        // $post = Post::find($post_id); // $post_idは実際の投稿のIDに置き換え。
        // $user = $post->user; // 関連するユーザーを取得。
        //dd($post);
        // $id = Auth::id();
        // $main_categories = $id->mainCategories;
        // dd($main_categories);
        // $post_main = Post::find($post_id);
        // //dd($post_main);
        // $mainCategories = $post_main->mainCategories();
        //dd($mainCategories);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    public function postInput(){
        $main_categories = MainCategory::get();
        //dd($main_categories);
        $sub_categories = SubCategory::get();
        //dd($sub_categories);
        return view('authenticated.bulletinboard.post_create', compact('main_categories','sub_categories'));
    }

    public function postCreate(PostFormRequest $request){
        //dd($request);
        $post_get = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body,
            'created_at' => now(), //追加
        ]);
        $sub_category_Id = auth()->id();
        //dd($sub_category_Id);
        $sub_category = $request->post_category_id;
        //dd($sub_category);
        $post = Post::findOrFail($post_get->id);
        //sub_categoryのIDを中間テーブルへ追加。
        $post->subCategories()->attach($sub_category);

        //$sub_category_name = $post->subCategories()->pluck('sub_category');
        //dd($sub_category_name);
        // $sub_category_name = SubCategory::whereIn('sub_category',$sub_category_name)->get();
        //dd($sub_category_name);
        // if(Post::with('user_id') === $post->subCategories()->pluck('sub_category_id')){
        //     $sub_category_name = $post->subCategories()->pluck('sub_category');
        //     dd($sub_category_name);
        // }

        // //グループに所属しているアクティブなユーザーを取得
        // $sub_category_name = $post->subCategories()->wherePivot('sub_category', true)->get();
        // dd($sub_category_name);

        return redirect()->route('post.show');
    }

    public function postEdit(PostEditRequest $request){
        //dd($request);
        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function postDelete($id){
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }

    //=====================================

    public function mainCategoryCreate(MainCategoryFormRequest $request){
        //dd($request);
        //$ans = $request->input('main_category_name');
        //dd($ans);
        MainCategory::create(['main_category' => $request->main_category_name]);
        $main_categories = MainCategory::get();
        //dd($main_categories);
        return redirect()->route('post.input');
    }

    //=====================================

     public function subCategoryCreate(SubCategoryFormRequest $request){
        //dd($request);
        //$value = $request->input('main_category');
        //dd($value);
        SubCategory::create([
            'main_category_id' =>$request->input('main_category'),
            'sub_category' => $request->sub_category_name,
        ]);
        return redirect()->route('post.input');
     }

    //=====================================

    public function commentCreate(CommentFormRequest $request){
        //dd($request);
        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function myBulletinBoard(){
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard(){
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        //dd($posts);
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    public function postLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
    }

    public function postUnLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
             ->where('like_post_id', $post_id)
             ->delete();

        return response()->json();
    }
}
