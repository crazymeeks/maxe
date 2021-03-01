@extends('layout.main')
@section('content')
@if(count($announcements) > 0)
<table class="table table-responsive">
    <caption>Announcements</caption>
    <thead>
        <tr>
            <th>Title</th>
            <th>Content</th>
        </tr>
    </thead>
    <tbody>
        @foreach($announcements as $announcement)
            <tr>
                <td>{{$announcement->title}}</td>
                <td>{{$announcement->content}}</td>
            </tr>
        @endforeach
    </tbody>
    {!! $announcements->links() !!}
</table>
@else
    <h3>No Announcement posted yet!</h3>

    <section id="header">
        <a href="{{url('/auth/login')}}" class="form-control">Sign in</a>
    </section>
@endif
@endsection