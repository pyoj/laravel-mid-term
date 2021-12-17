@extends("layout.app")

@section("title", "Tasks")

@section('content')
    <div class="container">
            @if ($message = Session::get("success"))
                <h1 style="color:green">{{ $message }}</h1>
            @endif
 
            <form class="add-form" action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <input type="text" name="description" id="description" placeholder="ახალი დავალება" />
                <button type="submit">
                    <i class="fas fa-plus"></i>
                    <span> დავალების დამატება</span>
                </button>
            </form>
      
            <div class="tasks-list">
                @foreach ($tasks as $task)
                <div class="task">
                    @if ($task->deleted_at)
                        <div class="done">
                            <span>{{$task->description}}<span>
                            <form  action="{{ route("tasks.restore", $task->id) }}" method="POST">
                                @csrf
                                <button type="submit"><i class="fas fa-check-circle"></i></button>
                            </form>
                        </div>
                    @else
                        <div class="undone">
                            <span>{{$task->description}}<span>
                            <form  action="{{ route("tasks.destroy", $task->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">
                                    @include('components.circle-icon')
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>

            <form class="delete-done" action="{{ route('tasks.deleteDones') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">
                    <i class="fas fa-trash-alt"></i>
                    <span>შესრულებული დავალებების წაშლა</span>
                </button>
            </form>
    </div>
@endsection