a@extends('layouts.app')
@section('title', 'Products Category')
@section('contents')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-2"><span class="text-muted fw-light">eCommerce /</span> Category List</h4>

        <div class="app-ecommerce-category">
            <!-- Category List Table -->
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="datatables-category-list table border-top">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Categories</th>
                                <th class="text-nowrap text-sm-end">Total Products &nbsp;</th>
                                <th class="text-nowrap text-sm-end">Total Earning</th>
                                <th class="text-lg-center">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- Offcanvas to add new customer -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEcommerceCategoryList"
                aria-labelledby="offcanvasEcommerceCategoryListLabel">
                <!-- Offcanvas Header -->
                <div class="offcanvas-header py-4">
                    <h5 id="offcanvasEcommerceCategoryListLabel" class="offcanvas-title">Add Category</h5>
                    <button type="button" class="btn-close bg-label-secondary text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <!-- Offcanvas Body -->
                <div class="offcanvas-body border-top">
                    <form class="pt-0" id="eCommerceCategoryList_Form" action="" method="POST">
                        {{ csrf_field() }}
                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label" for="ecommerce-category-title">Title</label>
                            <input type="text" class="form-control" id="ecommerce-category-title"
                                placeholder="Enter category title" name="categoryTitle" aria-label="category title" />
                        </div>
                        <!-- Slug -->
                        <div class="mb-3">
                            <label class="form-label" for="ecommerce-category-slug">Slug</label>
                            <input type="text" id="ecommerce-category-slug" class="form-control" placeholder="Enter slug"
                                aria-label="slug" name="slug" />
                        </div>
                        <!-- Image -->
                        {{-- <div class="mb-3">
                            <label class="form-label" for="ecommerce-category-image">Attachment</label>
                            <input class="form-control" type="file" id="ecommerce-category-image" />
                        </div> --}}
                        <!-- Parent category -->
                        <div class="mb-3 ecommerce-select2-dropdown">
                            <label class="form-label" for="ecommerce-category-parent-category">Parent category</label>
                            <select id="ecommerce-category-parent-category" name="parentCategory"
                                class="select2 form-select" data-placeholder="Select parent category">
                                <option value="">Select parent Category</option>
                                <option value="Household">Household</option>
                                <option value="Management">Management</option>
                                <option value="Electronics">Electronics</option>
                                <option value="Office">Office</option>
                                <option value="Automotive">Automotive</option>
                            </select>
                        </div>
                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <div class="form-control p-0 py-1">
                                <textarea name="description" class="form-control" id="" cols="30" rows="10">
                                </textarea>
                            </div>
                        </div>
                        <!-- Status -->
                        <div class="mb-4 ecommerce-select2-dropdown">
                            <label class="form-label">Select category status</label>
                            <select id="ecommerce-category-status" name="status" class="select2 form-select"
                                data-placeholder="Select category status">
                                <option value="">Select category status</option>
                                <option value="Scheduled">Scheduled</option>
                                <option value="Publish">Publish</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <!-- Submit and reset -->
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Add</button>
                            <button type="reset" class="btn bg-label-danger" data-bs-dismiss="offcanvas">Discard</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        < script >
            $(document).ready(function() {
                // Initialize Quill editor
                // var quill = new Quill('#ecommerce-category-description', {
                //     theme: 'snow'
                // });
                $('.datatables-category-list').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('getCategoryData') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'checkbox', name: 'checkbox' },
                    { data: 'title', name: 'title' },
                    { data: 'total_products', name: 'total_products' },
                    { data: 'total_earning', name: 'total_earning' },
                    { data: 'actions', name: 'actions' },
                ],
            });
                // Handle form submission
                $('#eCommerceCategoryList_Form').submit(function(e) {
                    e.preventDefault();

                    // Get the HTML content from Quill editor
                    // var descriptionValue = quill.root.innerHTML;

                    // Set the description value to the hidden input
                    // $('#description_val').val(descriptionValue);

                    // Submit the form using AJAX
                    $.ajax({
                        type: 'POST',
                        url: '/submit-category',
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            // Show SweetAlert on successful upload
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Category added successfully!',
                                timer: 2000, // Set a timer to automatically close the alert
                                showConfirmButton: false
                            });

                            // Optionally, reset the form
                            $('#eCommerceCategoryList_Form')[0].reset();
                        },
                        error: function(error) {
                            // Handle errors if needed
                            console.error(error);
                        }
                    });
                });
            });
    </script>
    </script>

@endsection
