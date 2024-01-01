<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Http\Requests\CommentsRequest;
use App\Models\User;
use App\Models\Event;
use App\Models\News;

class CommentController extends Controller
{
    /**
     * Get all comments by ID
     */
    public function show($id)
    {

        $comments = Comment::find($id);
        return $this->responseSuccess($comments, 'List Semua Komentar dengan ID' . $id);
    }

    /**
     * Get all comments by ID
     */
    public function getCommentsByType($type, $id)
    {

        $comments = Comment::where('type', $type)->where($type == 'event' ? 'events_id' : 'news_id', $id)->where('parent_id', 0)->orderBy('created_at', 'desc')->get();
        $results = [];
        foreach ($comments as $comment) {
            $user = User::find($comment->user_id);
            $results[] = [
                'id' => $comment->id,
                'events_id' => $comment->events_id,
                'news_id' => $comment->news_id,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                ],
                'child' => Comment::where('parent_id', $comment->id)->get(),
                'content' => $comment->content,
                'type' => $comment->type,
                'created_at' => $comment->created_at,
                'updated_at' => $comment->updated_at,
            ];
        }
        return $this->responseSuccess($results, 'List Semua Komentar dengan tipe ' . $type);
    }

    /**
     * Get all comments by parent ID
     */
    public function getCommentByParent($parentId, $type)
    {
        $comments = Comment::where('parent_id', $parentId)->where('type', $type)->get();
        return $this->responseSuccess('List Semua Komentar dengan parent ID' . $parentId, $comments);
    }

    /**
     * Get all comments
     */
    public function index()
    {
        $comments = Comment::all();
        $results = [];
        foreach ($comments as $comment) {
            $user = User::find($comment->user_id);
            $results[] = [
                'id' => $comment->id,
                'events' => Event::find($comment->events_id) ? Event::find($comment->events_id) : 0,
                'news' => News::find($comment->news_id) ? News::find($comment->news_id) : 0,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                ],
                'child' => Comment::where('parent_id', $comment->id)->get(),
                'content' => $comment->content,
                'type' => $comment->type,
                'created_at' => $comment->created_at,
                'updated_at' => $comment->updated_at,
            ];
        }
        return $this->responseSuccess($results, 'List Semua Komentar');
    }

    /**
     * Store Comment
     */
    public function store(CommentsRequest $request)
    {

        $comment = new Comment();
        $comment->type = $request->post('type');
        $comment->events_id = $request->post('type') == 'event' ? $request->post('post_id') : null;
        $comment->news_id = $request->post('type') == 'news' ? $request->post('post_id') : null;
        $comment->user_id = $request->post('user_id');
        $comment->parent_id = empty($request->post('parent_id')) ? 0 : $request->post('parent_id');
        $comment->content = $request->post('content');
        $comment->save();

        return $this->responseSuccess('Komentar berhasil ditambahkan', $comment);
    }

    /**
     * Delete comment by ID
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        if (!$comment) {
            return $this->responseError('Komentar tidak ditemukan', 404);
        }

        $comment->delete();
        return $this->responseSuccess('Komentar berhasil dihapus');
    }
}
