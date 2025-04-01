@extends('layouts.admin')
@section('content')
@section('title', 'Units - Admin Panel')

<div class="container">
    <div class="row justify-content-between mt-4 align-items-center">

        <div class="col-md-8 text-end">
            <form method="GET" action="{{ route('admin.units.search') }}" class="d-inline">
                <div class="input-group input-group-lg">
                    <input type="search" id="form1" name="search" class="form-control" placeholder="Search..." value="{{ request()->input('search') }}" />
                    <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-magnify" style="font-size: 25px;"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-2">
            <button class="btn btn-info fw-bold" onclick="openModal()">Add unit</button>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12 mt-5">
            <table class="table table-bordered text-center text-capitalize">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Symbol</th>
                        <th>Description</th>
                        <!-- <th>Created At</th>
                        <th>Updated At</th> -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($units as $unit)
                    <tr>
                        <td>{{ $unit->name }}</td>
                        <td>{{ $unit->symbol }}</td>
                        <td>{{ $unit->description }}</td>
                        <!-- <td>{{ \Carbon\Carbon::parse($unit->created_at)->format('d M, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($unit->updated_at)->format('d M, Y') }}</td> -->
                        <td>
                            <button class="btn btn-info btn-sm" onclick="openModal({{ $unit }})">Edit</button>
                            <form id="delete-unit-form-{{ $unit->id }}" action="{{ route('admin.units.destroy', $unit->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No units found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center mt-3">
                {!! $units->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
</div>

<!-- Modal -->

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="modal fade" id="unitModal" tabindex="-1" aria-labelledby="unitModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="unitForm" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="unitModalLabel">Add unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="unitId" name="_method" value="POST">
                    <div class="mb-3">
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter Unit name">
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="text" id="symbol" name="symbol" class="form-control" placeholder="Enter Unit Symbol">
                        @error('symbol')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <textarea id="description" name="description" class="form-control" rows="3" placeholder="Enter Unit description"></textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(unit = null) {
        const modal = new bootstrap.Modal(document.getElementById('unitModal'));
        const form = document.getElementById('unitForm');
        const modalTitle = document.getElementById('unitModalLabel');
        if (unit) {
            // Edit mode
            modalTitle.textContent = 'Edit unit';
            form.action = `{{ url('admin/units/update') }}/${unit.id}`;
            document.getElementById('unitId').value = 'PUT';
            document.getElementById('name').value = unit.name;
            document.getElementById('symbol').value = unit.symbol;
            document.getElementById('description').value = unit.description;
        } else {
            // Add mode
            modalTitle.textContent = 'Add unit';
            form.action = `{{ route('admin.units.store') }}`;
            document.getElementById('unitId').value = 'POST';
            form.reset();
        }
        modal.show();
    }
    
</script>
@endsection