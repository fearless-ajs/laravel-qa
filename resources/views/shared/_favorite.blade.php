
<form style="display: none; " id="favorite-question-{{$model->id}}" action="/questions/{{$model->id}}/favorites" method="post">
    @csrf
    @if($model->is_favorited)
        @method('DELETE')
    @endif
</form>
