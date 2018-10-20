@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('content')
    <section class="row-post">
        <div class="col-md-6 col-md-offset-3">
            <header><h3>Inserisci il tuo comando</h3></header>
            <form action="{{route('post.create')}}" method="post">
                <div class="form-group">
                    <textarea class="form-control" name="post" id="post" rows="5" placeholder="
    posting: <user name> -> <message>
    reading: <user name>
    following: <user name> follows <another user>
    wall: <user name> wall
"></textarea>
                </div>
            <button type="submit" class="btn btn-primary">Invia Comando</button>
                <input type="hidden" value="{{ Session::token() }}" name="_token">
            </form>
        </div>
    </section>
    @include('includes.messages')
    <section class="row posts">
        <div class="col-md-6 col-md-3-offset">
            <header><h3>cosa dicono i tuoi amici</h3></header>
            @foreach($posts as $post)
                <article class="post" data-postid="{{$post->id}}">
                    <p>{{$post->body}}</p>
                    <div class="info">
                      Scritto da {{$post->user->name}} il {{$post->created_at}}
                    </div>
                    <div class="interaction">
                        <a href="#" class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 1 ? 'Ti piace questo post' : 'Ti Piace' : 'Ti Piace'  }}</a> |
                        <a href="#" class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 0 ? 'Non ti piace questo post' : 'Non ti piace' : 'Non ti piace'  }}</a>
                        @if(Auth::user()==$post->user)
                        <a href="#" class="edit_post">Modifica</a>
                        <a href="{{route('post.delete',['post_id'=>$post->id])}}">Cancella</a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </section>
    <div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label class="post-body">Modifica Post</label>
                            <textarea class="form-control" name="post-body" id="post-body" cols="30" rows="10"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script>
        var token = '{{ Session::token() }}';
        var url = '{{route('edit')}}';
        var urlAction = '{{route('like')}}';
    </script>
@endsection