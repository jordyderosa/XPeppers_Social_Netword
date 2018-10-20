<?php
namespace App\Http\Controllers;
use App\Follows;
use App\Like;
use App\Post;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;




class PostController extends Controller {
    public function getDashboard()
    {
        $posts =Post::where('user_id',"=",User::where('name',"=",Auth::user()->name)->first()->id)->get();
        return view('dashboard',['posts' => $posts]);
    }
    public function postEditPost(Request $request)
    {
        $this->validate($request,[
            'body'=>'required'
        ]);
        $post=Post::find($request['postId']);
        if(Auth::user()!= $post->user)
        {
            return redirect()->back();
        }
        $post->body = $request['body'];
        $post->update();
        return response()->json(['new-post'=>$post->body],200);

        //return redirect()->route('dashboard')->with(['message'=>$msg]);
    }
    public function postLikePost(Request $request)
    {


        $post_id = $request['postId'];
        $action = $request['action'] === 'true';
        $update = false;
        $post = Post::find($post_id);
        if (!$post) {
            return null;
        }
        $user = Auth::user();
        $like = $user->likes()->where('post_id', $post_id)->first();
        if ($like) {
            $already_like = $like->like;
            $update = true;
            if ($already_like == $action) {
                $like->delete();
                return null;
            }
        } else {
            $like = new Like();
        }
        $like->like = $action;
        $like->user_id = $user->id;
        $like->post_id = $post->id;
        if ($update) {
            $like->update();
        } else {
            $like->save();
        }
        return null;

    }
    public function postCreatePost(Request $request)
    {
        $this->validate($request, [
            'post' => 'required|max:1000'
        ]);
        //azione comando post
        if(stristr($request['post'],'->'))
        {

            $post = new Post();
            $pos=stripos($request['post'],'->');
            $name= substr($request['post'],0,$pos);
            $pos = $pos+3;
            $post->body = substr($request['post'],$pos);

            if(User::where('name',"=",$name)->first())
            {
                $my_user = User::where('name', "=", $name)->first();

                //if ($request->user()->posts()->save($post))
                if ($my_user->posts()->save($post)) {
                    $msg = 'Post inviato!';
                } else {
                    $msg = 'Errore. Il posto non è stato regitrato correttamente. Riprova.';
                }
                return redirect()->route('dashboard')->with(['message' => $msg]);
            }
            else
            {
                return redirect()->route('dashboard')->with(['message' => "utente non ricosciuto"]);
            }
        }
        else if(stristr($request['post'],'wall'))
        {
            $pos=stripos($request['post'],'wall');
            $pos --;
            $name= substr($request['post'],0,$pos);
            if(User::where('name',"=",$name)->first())
            {
              $posts =Post::where('user_id',"=",User::where('name',"=",$name)->first()->id)->get();
                $followed_posts=Follows::where('user_id',"=",User::where('name',"=",$name)->first()->id)->get();
                for($i=0;$i<count($followed_posts);$i++)
                {   $id_to_search=$followed_posts[$i]["followed_user_id"];
                    $posts2 = Post::where('user_id',"=","$id_to_search")->get();
                    $posts=$posts->merge($posts2);
                }
                return view('dashboard',['posts' => $posts]);

            }
            else
            {
                return redirect()->route('dashboard')->with(['message'=>"utente non riconosciuto"]);
            }
        }
        else if(stristr($request['post'],'follows'))
        {
            $pos=stripos($request['post'],'follows');
            $pos_f=$pos--;
            $first_name=substr($request['post'],0,$pos_f);
            $pos_s=$pos+9;
            $second_name=substr($request['post'],$pos_s);
            if(User::where('name',"=",$first_name)->first() && User::where('name',"=",$second_name)->first())
            {
                $follows = new Follows();
                $first_id=User::where('name',"=",$first_name)->first()->id;
                $follows->user_id=$first_id;
                $second_id=User::where('name',"=",$second_name)->first()->id;
                $follows->followed_user_id=$second_id;
                $my_user = User::where('name', "=", $first_name)->first();
                if ($my_user->follows()->save($follows))
                {
                    return redirect()->route('dashboard')->with(['message'=>"Ora $first_name segue $second_name"]);
                }
                else
                {
                    return redirect()->route('dashboard')->with(['message'=>"Errore nel salvataggio del follows"]);
                }

            }
            else
            {
                return redirect()->route('dashboard')->with(['message'=>"utenti per comando fellows non riconosciuti = $first_name fellows $second_name"]);
            }
        }
        else if($request['post']=="")
        {
            //return redirect()->route('dashboard')->with(['message'=>"comando non riconosciuto"]);
            return null;
        }
        else
        {
            $user_name=$request['post'];
            if(User::where('name',"=",$request['post'])->first())
            {
                   $user_id=User::where('name',"=",$request['post'])->first()->id;
                   $posts=Post::where("user_id","=",$user_id)->get();
                   return view('dashboard',['posts' => $posts]);
            }
            else
            {
                return redirect()->route('dashboard')->with(['message'=>"comando non riconosciuto"]);
            }
        }

    }

    public function getDeletePost($post_id)
    {
        $post = Post::where('id','=',$post_id)->first();
        if(Auth::user() != $post->user) {
            return redirect()->back();
        }
        $post->delete();
        return redirect()->route('dashboard')->with(['message'=>'Post cancellato correttamente!']);
    }
}