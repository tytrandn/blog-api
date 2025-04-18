<?php
namespace App\Modules\Post\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest 
{
    
    public function rules() 
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author_id' => 'required|exists:users,id'
        ];
    }

}