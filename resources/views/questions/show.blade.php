@extends('layouts.app')

@section('content')
<question-page :question="{{$question}}"></question-page>
@endsection

<script>
    import Question from "../../js/components/Question";
    export default {
        components: {Question},
        props: ['question']
    }
</script>
