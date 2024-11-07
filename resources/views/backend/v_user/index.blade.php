@extends('backend.v_layout.app')
@section('content')


    <!-- contentAwal -->
    
    <a href="{{ route('backend.user.create') }}">
        <button class="btn btn-primary" type="button"><i class="fa fa-plus"></i> Add</button>
    </a>
    <br>
    <br>
<div class="card">
    <div class="card-body">
        <h3> {{ $judul }} </h3>
        <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Email</th>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($index as $row)
            <tr>
                <td> {{ $loop->iteration }} </td>
                <td> {{ $row->nama }} </td>
                <td> {{ $row->email }} </td>
                <td> @if ($row->role == 1)
                    <span class="badge badge-success"> Super Admin</span>
                    @elseif ($row->role == 0)
                    <span class="badge badge-primary"> Admin</span>
                @endif </td>
                <td> @if ($row->status == 1)
                    <span class="badge badge-success">Active</span>
                    @elseif ($row->status == 0)
                    <span class="badge badge-secondary">Non-Active</span>
                @endif </td>
                <td>
                    <a href="{{ route('backend.user.edit',$row->id) }}" class="btn btn-warning btn-sm" type="button"><i class="fa fa-edit"></i> Edit</a>

                    {{-- Tinggal pasang SA true/false --}}
                    <form action="{{ route('backend.user.destroy', $row->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm" id="show_confirm" data-konf-delete="{{ $row->nama }}" title="Hapus Data"><i class="fa fa-trash"></i> Delete</button>
                    </form>

                </td>
            </tr>
        @endforeach
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>

    </div>
</div>
</div>
</div>
@endsection
<!-- contentAkhir -->
