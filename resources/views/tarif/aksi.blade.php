<a href="/admin/tarifs/{{ $data->id }}/edit" class="badge badge-rounded badge-warning">Edit</a>
<form action="/admin/tarifs/{{ $data->id }}" method="POST">
@method('delete')
@csrf
<input type="hidden" name="id" value="{{ $data->id }}">
<button class="badge badge-rounded badge-danger" type="submit" onclick="return confirm('yakin')">Hapus
</button>
</form>


<div class="modal fade" id="hapus{{ $data->id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Data User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <h5>Apakah anda yakin untuk menghapus?</h5>
                <form action="/admin/tarifs/{{ $data->id }}" method="POST">
                    @method('delete')
                    @csrf
                    <input type="hidden" name="id" value="{{ $data->id }}">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
