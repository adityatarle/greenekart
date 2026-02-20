@extends('admin.layout')

@section('title', 'Subcategories Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Subcategories Management</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.subcategories.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Subcategory
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.subcategories.index') }}" class="mb-3">
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <input type="text" name="search" class="form-control" style="max-width: 280px;" placeholder="Search by name or description..." value="{{ request('search') }}">
                            <select name="category_id" class="form-select" style="max-width: 220px;" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i> Search</button>
                            @if(request('search') || request('category_id'))
                                <a href="{{ route('admin.subcategories.index') }}" class="btn btn-outline-secondary">Clear</a>
                            @endif
                        </div>
                    </form>

                    @if($subcategories->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Products</th>
                                        <th>Status</th>
                                        <th>Sort Order</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subcategories as $subcategory)
                                    <tr>
                                        <td>
                                            @if($subcategory->image)
                                                @php
                                                $imageUrl = \App\Helpers\ImageHelper::imageUrl($subcategory->image);
                                                @endphp
                                                <img src="{{ $imageUrl }}" alt="{{ $subcategory->name }}" class="img-thumbnail" style="max-width: 50px; max-height: 50px; object-fit: cover;">
                                            @else
                                                <span class="text-muted">No image</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($subcategory->icon)
                                                    <i class="{{ $subcategory->icon }} me-2"></i>
                                                @endif
                                                <strong>{{ $subcategory->name }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $subcategory->category->name ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                {{ Str::limit($subcategory->description, 50) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $subcategory->products_count }} products</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $subcategory->is_active ? 'success' : 'secondary' }}">
                                                {{ $subcategory->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>{{ $subcategory->sort_order }}</td>
                                        <td>{{ $subcategory->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.subcategories.show', $subcategory) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.subcategories.edit', $subcategory) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.subcategories.destroy', $subcategory) }}" method="POST" class="d-inline delete-form" data-name="{{ $subcategory->name }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger delete-btn">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $subcategories->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No Subcategories Found</h4>
                            <p class="text-muted">Create your first subcategory to organize your agriculture products.</p>
                            <a href="{{ route('admin.subcategories.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create Subcategory
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Handle delete confirmations with SweetAlert
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const subcategoryName = form.getAttribute('data-name') || 'this subcategory';
            
            Swal.fire({
                title: 'Delete Subcategory?',
                html: `Are you sure you want to delete <strong>${subcategoryName}</strong>?<br><small class="text-danger">This action cannot be undone!</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
@endsection

