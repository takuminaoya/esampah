@extends('layout.backend.core')
@section('css')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<style>
    #sortable-banjar { list-style-type: none; margin: 0; padding: 0; width: 100%; }
    #sortable-banjar .list-group-item { 
        margin: 0 0 5px 0; 
        padding: 8px 15px 8px 35px; 
        position: relative;
    }
    .drag-handle { 
        position: absolute; 
        left: 10px; 
        transform: translateY(-50%); 
        cursor: move;
        color: #aaa;
    }
    .banjar-item {
        border-left: 4px solid #4e73df;
    }
    .banjar-item.ui-state-highlight {
        height: 40px;
        background: #f8f9fa;
        border: 1px dashed #ccc;
    }
</style>
@endsection

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Tambah Jalur</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card widget widget-popular-blog">
                        <div class="card-body">
                            <form action="{{ route('jalur.store') }}" method="post" id="jalur-form">
                                @csrf
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                <div class="row mb-3">
                                    <label for="nama" class="col-sm-2 col-form-label">Nama Jalur</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}">
                                        @error('nama')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Banjar</label>
                                    <div class="col-sm-10" id="banjar-container">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0">Daftar Banjar (Drag & Drop untuk mengurutkan)</h5>
                                                <button type="button" class="btn btn-sm btn-primary" id="add-banjar-btn">
                                                    <i class="fas fa-plus"></i> Tambah Banjar
                                                </button>
                                            </div>
                                            <div class="card-body">
                                                <ul id="sortable-banjar" class="list-group">
                                                    <!-- Banjar items will be added here -->
                                                </ul>
                                                
                                                <div class="alert alert-info mt-3">
                                                    <i class="fas fa-info-circle"></i> Belum ada banjar yang ditambahkan. Silakan tambahkan banjar menggunakan tombol "Tambah Banjar".
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Modal for adding banjar -->
                                        <div class="modal fade" id="banjarModal" tabindex="-1" aria-labelledby="banjarModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="banjarModalLabel">Pilih Banjar</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            @foreach($banjars as $banjar)
                                                                <div class="col-md-4 mb-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input available-banjar" type="checkbox" value="{{ $banjar->id }}" id="available-{{ $banjar->id }}">
                                                                        <label class="form-check-label" for="available-{{ $banjar->id }}">
                                                                            {{ $banjar->nama }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        <button type="button" class="btn btn-primary" id="save-banjar">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary float-end">Simpan</button>
                                        <a href="{{ route('jalur.index') }}" class="btn btn-secondary float-end me-2">Kembali</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
        // Add FontAwesome icons
        $('<link>').attr({
            rel: 'stylesheet',
            href: 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css'
        }).appendTo('head');
        
        // Function to initialize or reinitialize sortable
        function initSortable() {
            // Destroy if already initialized to prevent duplicate initialization
            if ($("#sortable-banjar").hasClass("ui-sortable")) {
                $("#sortable-banjar").sortable("destroy");
            }
            
            // Initialize sortable with minimal options
            $("#sortable-banjar").sortable({
                handle: ".drag-handle",
                placeholder: "list-group-item banjar-item ui-state-highlight",
                update: function(event, ui) {
                    updateBanjarOrder();
                }
            }).disableSelection();
        }
        
        // Initial sortable initialization
        initSortable();
        
        // Open modal when Add Banjar button is clicked
        $("#add-banjar-btn").on("click", function() {
            $("#banjarModal").modal('show');
        });
        
        // Handle save button in modal
        $("#save-banjar").on("click", function() {
            const selectedBanjars = [];
            
            // Get all checked banjars
            $(".available-banjar:checked").each(function() {
                selectedBanjars.push({
                    id: $(this).val(),
                    name: $(this).next('label').text().trim()
                });
            });
            
            // Clear current list
            $("#sortable-banjar").empty();
            
            // Add selected banjars to the list
            if (selectedBanjars.length > 0) {
                $.each(selectedBanjars, function(index, banjar) {
                    $("#sortable-banjar").append(
                        `<li class="list-group-item d-flex justify-content-between align-items-center banjar-item" data-banjar-id="${banjar.id}">
                            <div>
                                <input type="hidden" name="banjar_ids[]" value="${banjar.id}">
                                <i class="fas fa-grip-vertical drag-handle"></i>
                                ${banjar.name}
                            </div>
                        </li>`
                    );
                });
                
                // Reinitialize sortable after adding new items
                initSortable();
                
                // Update the order via AJAX
                updateBanjarOrder();
                
                // Hide the info alert if it exists
                $(".alert-info").hide();
            } else {
                // Show info alert if no banjars selected
                if ($("#sortable-banjar .alert-info").length === 0) {
                    $("#sortable-banjar").append(
                        `<div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle"></i> Belum ada banjar yang ditambahkan. Silakan tambahkan banjar menggunakan tombol "Tambah Banjar".
                        </div>`
                    );
                } else {
                    $(".alert-info").show();
                }
            }
            
            // Close modal
            $("#banjarModal").modal('hide');
        });
        
        // Function to update the order of banjar IDs in the form
        function updateBanjarOrder() {
            // Remove all hidden inputs
            $('input[name="banjar_ids[]"]').remove();
            
            // Add hidden inputs in the current order
            $("#sortable-banjar li").each(function() {
                const banjarId = $(this).data("banjar-id");
                $(this).find("div").prepend(`<input type="hidden" name="banjar_ids[]" value="${banjarId}">`);
            });
        }
    });
</script>
@endpush
   
   
  