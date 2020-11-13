@can('accept', $model)
    <a href="#" title="Mark this answer as best answer (Click again to undo)" class="{{$model->status}} mt-2"
       onclick="event.preventDefault(); document.getElementById('accept-answer-{{$model->id}}').submit(); ">
        <i class="fas fa-check fa-2x"></i>
    </a>
    <form style="display: none; " id="accept-answer-{{$model->id}}" action="{{ route('answer.accept', $model->id) }}" method="post">
        @csrf
    </form>
@else
    @if($model->is_best)
        <a href="#" title="The question owner accepted this answer is best answer" class="{{$model->status}} mt-2">
            <i class="fas fa-check fa-2x"></i>
        </a>
    @endif
@endcan
