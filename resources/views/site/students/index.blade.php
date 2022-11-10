@extends('site.master')

@section('title', 'Students')

@section('content')
    <h1 class="text-center my-5">All Students</h1>

    <button class="btn btn-primary mb-5" id="add-btn">Add Student</button>

    {{-- Success and Error Messages --}}
    @include('site.inc.messages')
    
    <table class="table my-5">
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Student Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
            <tr>
                <th>{{$loop->iteration}}</th>
                <td>{{$student->name}}</td>
                <td>{{$student->email}}</td>
                <td>
                    <a class="btn btn-info edit-btn" data-id="{{$student->id}}">
                        Edit
                    </a>
                    <form action="{{route('students.destroy', $student->id)}}" method="POST" class="delete-form d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Begin Popup Modals --}}
    @include('site.students.modals.add_std_modal')
    @include('site.students.modals.edit_std_modal')
    {{-- End Popup Modals --}}

    {{-- Begin JS Scripts --}}
    @push('footer-js')
        @include('site.students.js.add_std_script')
        @include('site.students.js.edit_std_script')
        @include('site.students.js.delete_std_script')
    @endpush
    {{-- End JS Scripts --}}

@endsection

