<table class="table">
    <thead class="table-primary">
      <tr>
        <th>#</th>
        <th>Sponsor</th>
        <th>Fund</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">
      @foreach ($funding as $f)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $f->User->username }}</td>
          <td>Rp. {{ number_format($f->fund,2,',','.') }}</td>
          <td>{{ $f->created_at->toDateString() }}</td>
        </tr>
      @endforeach
    </tbody>
</table>
<div class="col-12 text-center mt-3">
    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
</div>