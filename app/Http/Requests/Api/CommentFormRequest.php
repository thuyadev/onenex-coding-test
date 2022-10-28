<?php

namespace App\Http\Requests\Api;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;

class CommentFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'movie_id' => 'required|exists:movies,id',
            'parent_id' => 'nullable',
            'comment' => 'required|string'
        ];
    }

    /**
     * @param array $data
     * @return Comment
     */
    public function toComment(array $data): Comment
    {
        $comment = new Comment($data);
        $comment['user_id'] = auth()->user()->id;

        return $comment;
    }
}
