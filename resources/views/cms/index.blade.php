@extends('layout.main')

@section('content')
<table class="table table-responsive">
    <thead>
        <tr>
            <th>Title</th>
            <th>Content</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="table-body">

    </tbody>
</table>

<div class="modal fade" id="addFormModal" tabindex="-1" role="dialog" aria-labelledby="addFormModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addFormModalLabel">Announcement</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="" class="control-label">Title</label>
            <input type="text" class="form-control" id="title">
        </div>
        <div class="form-group">
            <label for="" class="control-label">Content</label>
            <textarea name="content" class="form-control" id="content" cols="30" rows="10"></textarea>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Start Date</label>
            <input type="date" class="form-control" id="start_date">
        </div>
        <div class="form-group">
            <label for="" class="control-label">End Date</label>
            <input type="date" class="form-control" id="end_date">
        </div>
        <div class="form-group">
            <label for="" class="control-label">Active</label>
            <input type="checkbox" id="active">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btn-close" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-save">Save</button>
      </div>
    </div>
  </div>
</div>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addFormModal">
  Add new
</button>
@endsection

@section('scripts')
<script type="text/javascript">
    var url = "{{route('api.announcement.listing')}}";
    window.post_announcement_url = "{{route('api.save.announcement')}}";
    app.init().loadAnnouncements(url);
</script>
@append