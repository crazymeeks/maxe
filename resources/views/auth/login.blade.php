@extends('layout.main')

@section('content')
<div class="row">
    <div class="col-md-12">
        <form action="">
            <h3>Sign in</h3>
            <div class="form-group">
                <label for="" class="control-label">Email</label>
                <input type="email" class="form-control" id="email">
            </div>
            <div class="form-group">
                <label for="" class="control-label">Password</label>
                <input type="password" class="form-control" id="password">
            </div>
            <div class="form-group">
                <button id="btn-continue" class="btn btn-primary">Continue</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
window.ajax_url = "{{route('api.post.login')}}";
app.init().login();
</script>
@append