@extends('layouts.app')

@section('title', 'Suppliers')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-truck me-2"></i>Suppliers
                    </h4>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSupplierModal">
                        <i class="fas fa-plus me-2"></i>Add Supplier
                    </button>
                </div>
                <div class="card-body">
                    <!-- Search and Filter Section -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="form-control" id="searchInput" placeholder="Search suppliers...">
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <button type="button" class="btn btn-outline-secondary" id="refreshBtn">
                                <i class="fas fa-sync-alt me-2"></i>Refresh
                            </button>
                        </div>
                    </div>

                    <!-- Suppliers Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="suppliersTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Contact Person</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Products</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="suppliersTableBody">
                                <!-- Suppliers will be loaded here -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Showing <span id="showingStart">0</span> to <span id="showingEnd">0</span> of <span id="totalRecords">0</span> suppliers
                        </div>
                        <nav aria-label="Suppliers pagination">
                            <ul class="pagination mb-0" id="pagination">
                                <!-- Pagination will be generated here -->
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Supplier Modal -->
<div class="modal fade" id="createSupplierModal" tabindex="-1" aria-labelledby="createSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSupplierModalLabel">
                    <i class="fas fa-plus me-2"></i>Create New Supplier
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createSupplierForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="supplierName" class="form-label">Supplier Name *</label>
                                <input type="text" class="form-control" id="supplierName" name="name" required maxlength="255">
                                <div class="invalid-feedback" id="nameError"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="supplierCode" class="form-label">Supplier Code</label>
                                <input type="text" class="form-control" id="supplierCode" name="code" maxlength="50">
                                <div class="invalid-feedback" id="codeError"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contactPerson" class="form-label">Contact Person</label>
                                <input type="text" class="form-control" id="contactPerson" name="contact_person" maxlength="255">
                                <div class="invalid-feedback" id="contactPersonError"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contactPosition" class="form-label">Contact Position</label>
                                <input type="text" class="form-control" id="contactPosition" name="contact_position" maxlength="100">
                                <div class="invalid-feedback" id="contactPositionError"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="supplierEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="supplierEmail" name="email" maxlength="255">
                                <div class="invalid-feedback" id="emailError"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="supplierPhone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="supplierPhone" name="phone" maxlength="20">
                                <div class="invalid-feedback" id="phoneError"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="supplierWebsite" class="form-label">Website</label>
                                <input type="url" class="form-control" id="supplierWebsite" name="website" maxlength="255">
                                <div class="invalid-feedback" id="websiteError"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="supplierStatus" class="form-label">Status</label>
                                <select class="form-select" id="supplierStatus" name="is_active">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <div class="invalid-feedback" id="isActiveError"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="supplierAddress" class="form-label">Address</label>
                        <textarea class="form-control" id="supplierAddress" name="address" rows="3" maxlength="500"></textarea>
                        <div class="invalid-feedback" id="addressError"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="supplierCity" class="form-label">City</label>
                                <input type="text" class="form-control" id="supplierCity" name="city" maxlength="100">
                                <div class="invalid-feedback" id="cityError"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="supplierState" class="form-label">State/Province</label>
                                <input type="text" class="form-control" id="supplierState" name="state" maxlength="100">
                                <div class="invalid-feedback" id="stateError"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="supplierPostalCode" class="form-label">Postal Code</label>
                                <input type="text" class="form-control" id="supplierPostalCode" name="postal_code" maxlength="20">
                                <div class="invalid-feedback" id="postalCodeError"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="supplierCountry" class="form-label">Country</label>
                                <input type="text" class="form-control" id="supplierCountry" name="country" maxlength="100" value="United States">
                                <div class="invalid-feedback" id="countryError"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="supplierTaxId" class="form-label">Tax ID</label>
                                <input type="text" class="form-control" id="supplierTaxId" name="tax_id" maxlength="100">
                                <div class="invalid-feedback" id="taxIdError"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="supplierNotes" class="form-label">Notes</label>
                        <textarea class="form-control" id="supplierNotes" name="notes" rows="3" maxlength="1000"></textarea>
                        <div class="invalid-feedback" id="notesError"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Create Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Supplier Modal -->
<div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="editSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSupplierModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Supplier
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editSupplierForm">
                <input type="hidden" id="editSupplierId" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editSupplierName" class="form-label">Supplier Name *</label>
                                <input type="text" class="form-control" id="editSupplierName" name="name" required maxlength="255">
                                <div class="invalid-feedback" id="editNameError"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editSupplierCode" class="form-label">Supplier Code</label>
                                <input type="text" class="form-control" id="editSupplierCode" name="code" maxlength="50">
                                <div class="invalid-feedback" id="editCodeError"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editContactPerson" class="form-label">Contact Person</label>
                                <input type="text" class="form-control" id="editContactPerson" name="contact_person" maxlength="255">
                                <div class="invalid-feedback" id="editContactPersonError"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editContactPosition" class="form-label">Contact Position</label>
                                <input type="text" class="form-control" id="editContactPosition" name="contact_position" maxlength="100">
                                <div class="invalid-feedback" id="editContactPositionError"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editSupplierEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="editSupplierEmail" name="email" maxlength="255">
                                <div class="invalid-feedback" id="editEmailError"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editSupplierPhone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="editSupplierPhone" name="phone" maxlength="20">
                                <div class="invalid-feedback" id="editPhoneError"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editSupplierWebsite" class="form-label">Website</label>
                                <input type="url" class="form-control" id="editSupplierWebsite" name="website" maxlength="255">
                                <div class="invalid-feedback" id="editWebsiteError"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editSupplierStatus" class="form-label">Status</label>
                                <select class="form-select" id="editSupplierStatus" name="is_active">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <div class="invalid-feedback" id="editIsActiveError"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="editSupplierAddress" class="form-label">Address</label>
                        <textarea class="form-control" id="editSupplierAddress" name="address" rows="3" maxlength="500"></textarea>
                        <div class="invalid-feedback" id="editAddressError"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editSupplierCity" class="form-label">City</label>
                                <input type="text" class="form-control" id="editSupplierCity" name="city" maxlength="100">
                                <div class="invalid-feedback" id="editCityError"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editSupplierState" class="form-label">State/Province</label>
                                <input type="text" class="form-control" id="editSupplierState" name="state" maxlength="100">
                                <div class="invalid-feedback" id="editStateError"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editSupplierPostalCode" class="form-label">Postal Code</label>
                                <input type="text" class="form-control" id="editSupplierPostalCode" name="postal_code" maxlength="20">
                                <div class="invalid-feedback" id="editPostalCodeError"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editSupplierCountry" class="form-label">Country</label>
                                <input type="text" class="form-control" id="editSupplierCountry" name="country" maxlength="100">
                                <div class="invalid-feedback" id="editCountryError"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editSupplierTaxId" class="form-label">Tax ID</label>
                                <input type="text" class="form-control" id="editSupplierTaxId" name="tax_id" maxlength="100">
                                <div class="invalid-feedback" id="editTaxIdError"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="editSupplierNotes" class="form-label">Notes</label>
                        <textarea class="form-control" id="editSupplierNotes" name="notes" rows="3" maxlength="1000"></textarea>
                        <div class="invalid-feedback" id="editNotesError"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-2"></i>Update Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteSupplierModal" tabindex="-1" aria-labelledby="deleteSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteSupplierModalLabel">
                    <i class="fas fa-exclamation-triangle me-2 text-warning"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the supplier "<strong id="deleteSupplierName"></strong>"?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Warning:</strong> This action cannot be undone. If the supplier has associated products or purchases, deletion will be prevented.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fas fa-trash me-2"></i>Delete Supplier
                </button>
            </div>
        </div>
    </div>
</div>

<!-- View Supplier Details Modal -->
<div class="modal fade" id="viewSupplierModal" tabindex="-1" aria-labelledby="viewSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewSupplierModalLabel">
                    <i class="fas fa-eye me-2"></i>Supplier Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Supplier Information</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><strong>ID:</strong></td>
                                <td id="viewSupplierId"></td>
                            </tr>
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td id="viewSupplierName"></td>
                            </tr>
                            <tr>
                                <td><strong>Code:</strong></td>
                                <td id="viewSupplierCode"></td>
                            </tr>
                            <tr>
                                <td><strong>Contact Person:</strong></td>
                                <td id="viewContactPerson"></td>
                            </tr>
                            <tr>
                                <td><strong>Position:</strong></td>
                                <td id="viewContactPosition"></td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td id="viewSupplierEmail"></td>
                            </tr>
                            <tr>
                                <td><strong>Phone:</strong></td>
                                <td id="viewSupplierPhone"></td>
                            </tr>
                            <tr>
                                <td><strong>Website:</strong></td>
                                <td id="viewSupplierWebsite"></td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td id="viewSupplierStatus"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Address Information</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><strong>Address:</strong></td>
                                <td id="viewSupplierAddress"></td>
                            </tr>
                            <tr>
                                <td><strong>City:</strong></td>
                                <td id="viewSupplierCity"></td>
                            </tr>
                            <tr>
                                <td><strong>State:</strong></td>
                                <td id="viewSupplierState"></td>
                            </tr>
                            <tr>
                                <td><strong>Postal Code:</strong></td>
                                <td id="viewSupplierPostalCode"></td>
                            </tr>
                            <tr>
                                <td><strong>Country:</strong></td>
                                <td id="viewSupplierCountry"></td>
                            </tr>
                            <tr>
                                <td><strong>Tax ID:</strong></td>
                                <td id="viewSupplierTaxId"></td>
                            </tr>
                            <tr>
                                <td><strong>Notes:</strong></td>
                                <td id="viewSupplierNotes"></td>
                            </tr>
                            <tr>
                                <td><strong>Created:</strong></td>
                                <td id="viewSupplierCreated"></td>
                            </tr>
                            <tr>
                                <td><strong>Updated:</strong></td>
                                <td id="viewSupplierUpdated"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-12">
                        <h6>Products from this Supplier</h6>
                        <div id="supplierProductsList">
                            <!-- Products will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let suppliers = [];

    // Initialize the page
    loadSuppliers();

    // Event listeners
    document.getElementById('searchInput').addEventListener('input', debounce(handleSearch, 300));
    document.getElementById('refreshBtn').addEventListener('click', loadSuppliers);
    document.getElementById('createSupplierForm').addEventListener('submit', handleCreateSupplier);
    document.getElementById('editSupplierForm').addEventListener('submit', handleEditSupplier);
    document.getElementById('confirmDeleteBtn').addEventListener('click', handleDeleteSupplier);

    // Load suppliers from API
    async function loadSuppliers() {
        try {
            showLoading();
            const response = await fetch('/api/v1/suppliers', {
                headers: {
                    'Accept': 'application/json'
                }
            });
            if (response.ok) {
                const data = await response.json();
                suppliers = data.data;
                displaySuppliers();
                updatePagination();
            } else {
                showError('Failed to load suppliers');
            }
        } catch (error) {
            showError('Error loading suppliers: ' + error.message);
        } finally {
            hideLoading();
        }
    }

    // Display suppliers in table
    function displaySuppliers() {
        const tbody = document.getElementById('suppliersTableBody');
        tbody.innerHTML = '';

        if (suppliers.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="fas fa-truck fa-2x mb-3"></i>
                        <p>No suppliers found</p>
                    </td>
                </tr>
            `;
            return;
        }

        suppliers.forEach(supplier => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${supplier.id}</td>
                <td>
                    <span class="fw-bold">${escapeHtml(supplier.name)}</span>
                    ${supplier.code ? `<br><small class="text-muted">${escapeHtml(supplier.code)}</small>` : ''}
                </td>
                <td>${escapeHtml(supplier.contact_person || 'N/A')}</td>
                <td>
                    ${supplier.email ? `<a href="mailto:${supplier.email}">${escapeHtml(supplier.email)}</a>` : 'N/A'}
                </td>
                <td>${supplier.phone || 'N/A'}</td>
                <td>
                    ${supplier.is_active ? 
                        '<span class="badge bg-success">Active</span>' : 
                        '<span class="badge bg-secondary">Inactive</span>'
                    }
                </td>
                <td>
                    <span class="badge bg-info">${supplier.products_count || 0}</span>
                </td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-primary" onclick="viewSupplier(${supplier.id})" title="View">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-outline-warning" onclick="editSupplier(${supplier.id})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="deleteSupplier(${supplier.id}, '${escapeHtml(supplier.name)}')" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    // Handle search
    function handleSearch() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const filteredSuppliers = suppliers.filter(supplier => 
            supplier.name.toLowerCase().includes(searchTerm) ||
            (supplier.code && supplier.code.toLowerCase().includes(searchTerm)) ||
            (supplier.contact_person && supplier.contact_person.toLowerCase().includes(searchTerm)) ||
            (supplier.email && supplier.email.toLowerCase().includes(searchTerm)) ||
            (supplier.phone && supplier.phone.toLowerCase().includes(searchTerm))
        );
        displayFilteredSuppliers(filteredSuppliers);
    }

    // Display filtered suppliers
    function displayFilteredSuppliers(filteredSuppliers) {
        const tbody = document.getElementById('suppliersTableBody');
        tbody.innerHTML = '';

        if (filteredSuppliers.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="fas fa-search fa-2x mb-3"></i>
                        <p>No suppliers match your search</p>
                    </td>
                </tr>
            `;
            return;
        }

        filteredSuppliers.forEach(supplier => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${supplier.id}</td>
                <td>
                    <span class="fw-bold">${escapeHtml(supplier.name)}</span>
                    ${supplier.code ? `<br><small class="text-muted">${escapeHtml(supplier.code)}</small>` : ''}
                </td>
                <td>${escapeHtml(supplier.contact_person || 'N/A')}</td>
                <td>
                    ${supplier.email ? `<a href="mailto:${supplier.email}">${escapeHtml(supplier.email)}</a>` : 'N/A'}
                </td>
                <td>${supplier.phone || 'N/A'}</td>
                <td>
                    ${supplier.is_active ? 
                        '<span class="badge bg-success">Active</span>' : 
                        '<span class="badge bg-secondary">Inactive</span>'
                    }
                </td>
                <td>
                    <span class="badge bg-info">${supplier.products_count || 0}</span>
                </td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-primary" onclick="viewSupplier(${supplier.id})" title="View">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-outline-warning" onclick="editSupplier(${supplier.id})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="deleteSupplier(${supplier.id}, '${escapeHtml(supplier.name)}')" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    // Handle create supplier
    async function handleCreateSupplier(e) {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        const supplierData = Object.fromEntries(formData.entries());
        supplierData.is_active = supplierData.is_active === '1';

        try {
            const response = await fetch('/api/v1/suppliers', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(supplierData)
            });

            if (response.ok) {
                showSuccess('Supplier created successfully');
                bootstrap.Modal.getInstance(document.getElementById('createSupplierModal')).hide();
                e.target.reset();
                loadSuppliers();
            } else {
                const errorData = await response.json();
                showValidationErrors(errorData.errors);
            }
        } catch (error) {
            showError('Error creating supplier: ' + error.message);
        }
    }

    // Handle edit supplier
    async function handleEditSupplier(e) {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        const supplierId = formData.get('id');
        const supplierData = Object.fromEntries(formData.entries());
        supplierData.is_active = supplierData.is_active === '1';

        try {
            const response = await fetch(`/api/v1/suppliers/${supplierId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(supplierData)
            });

            if (response.ok) {
                showSuccess('Supplier updated successfully');
                bootstrap.Modal.getInstance(document.getElementById('editSupplierModal')).hide();
                loadSuppliers();
            } else {
                const errorData = await response.json();
                showValidationErrors(errorData.errors, 'edit');
            }
        } catch (error) {
            showError('Error updating supplier: ' + error.message);
        }
    }

    // Handle delete supplier
    async function handleDeleteSupplier() {
        const supplierId = document.getElementById('confirmDeleteBtn').getAttribute('data-supplier-id');
        
        try {
            const response = await fetch(`/api/v1/suppliers/${supplierId}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                showSuccess('Supplier deleted successfully');
                bootstrap.Modal.getInstance(document.getElementById('deleteSupplierModal')).hide();
                loadSuppliers();
            } else {
                const errorData = await response.json();
                showError(errorData.message || 'Failed to delete supplier');
            }
        } catch (error) {
            showError('Error deleting supplier: ' + error.message);
        }
    }

    // Utility functions
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    function showLoading() {
        // Add loading indicator
    }

    function hideLoading() {
        // Remove loading indicator
    }

    function showSuccess(message) {
        // Show success message
        alert(message); // Replace with proper toast notification
    }

    function showError(message) {
        // Show error message
        alert('Error: ' + message); // Replace with proper toast notification
    }

    function showValidationErrors(errors, prefix = '') {
        // Clear previous errors
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

        // Show new errors
        Object.keys(errors).forEach(field => {
            const input = document.getElementById(prefix + field.charAt(0).toUpperCase() + field.slice(1));
            const errorDiv = document.getElementById(prefix + field.charAt(0).toUpperCase() + field.slice(1) + 'Error');
            
            if (input && errorDiv) {
                input.classList.add('is-invalid');
                errorDiv.textContent = errors[field][0];
            }
        });
    }

    function updatePagination() {
        // Update pagination info
        const total = suppliers.length;
        document.getElementById('totalRecords').textContent = total;
        document.getElementById('showingStart').textContent = total > 0 ? 1 : 0;
        document.getElementById('showingEnd').textContent = total;
    }
});

// Global functions for modal actions
function viewSupplier(supplierId) {
    const supplier = suppliers.find(s => s.id === supplierId);
    if (supplier) {
        document.getElementById('viewSupplierId').textContent = supplier.id;
        document.getElementById('viewSupplierName').textContent = supplier.name;
        document.getElementById('viewSupplierCode').textContent = supplier.code || 'N/A';
        document.getElementById('viewContactPerson').textContent = supplier.contact_person || 'N/A';
        document.getElementById('viewContactPosition').textContent = supplier.contact_position || 'N/A';
        document.getElementById('viewSupplierEmail').textContent = supplier.email || 'N/A';
        document.getElementById('viewSupplierPhone').textContent = supplier.phone || 'N/A';
        document.getElementById('viewSupplierWebsite').textContent = supplier.website || 'N/A';
        document.getElementById('viewSupplierStatus').innerHTML = supplier.is_active ? 
            '<span class="badge bg-success">Active</span>' : 
            '<span class="badge bg-secondary">Inactive</span>';
        document.getElementById('viewSupplierAddress').textContent = supplier.address || 'N/A';
        document.getElementById('viewSupplierCity').textContent = supplier.city || 'N/A';
        document.getElementById('viewSupplierState').textContent = supplier.state || 'N/A';
        document.getElementById('viewSupplierPostalCode').textContent = supplier.postal_code || 'N/A';
        document.getElementById('viewSupplierCountry').textContent = supplier.country || 'N/A';
        document.getElementById('viewSupplierTaxId').textContent = supplier.tax_id || 'N/A';
        document.getElementById('viewSupplierNotes').textContent = supplier.notes || 'N/A';
        document.getElementById('viewSupplierCreated').textContent = formatDate(supplier.created_at);
        document.getElementById('viewSupplierUpdated').textContent = formatDate(supplier.updated_at);
        
        // Load products from this supplier
        loadSupplierProducts(supplierId);
        
        new bootstrap.Modal(document.getElementById('viewSupplierModal')).show();
    }
}

function editSupplier(supplierId) {
    const supplier = suppliers.find(s => s.id === supplierId);
    if (supplier) {
        document.getElementById('editSupplierId').value = supplier.id;
        document.getElementById('editSupplierName').value = supplier.name;
        document.getElementById('editSupplierCode').value = supplier.code || '';
        document.getElementById('editContactPerson').value = supplier.contact_person || '';
        document.getElementById('editContactPosition').value = supplier.contact_position || '';
        document.getElementById('editSupplierEmail').value = supplier.email || '';
        document.getElementById('editSupplierPhone').value = supplier.phone || '';
        document.getElementById('editSupplierWebsite').value = supplier.website || '';
        document.getElementById('editSupplierStatus').value = supplier.is_active ? '1' : '0';
        document.getElementById('editSupplierAddress').value = supplier.address || '';
        document.getElementById('editSupplierCity').value = supplier.city || '';
        document.getElementById('editSupplierState').value = supplier.state || '';
        document.getElementById('editSupplierPostalCode').value = supplier.postal_code || '';
        document.getElementById('editSupplierCountry').value = supplier.country || '';
        document.getElementById('editSupplierTaxId').value = supplier.tax_id || '';
        document.getElementById('editSupplierNotes').value = supplier.notes || '';
        
        new bootstrap.Modal(document.getElementById('editSupplierModal')).show();
    }
}

function deleteSupplier(supplierId, supplierName) {
    document.getElementById('deleteSupplierName').textContent = supplierName;
    document.getElementById('confirmDeleteBtn').setAttribute('data-supplier-id', supplierId);
    
    new bootstrap.Modal(document.getElementById('deleteSupplierModal')).show();
}

async function loadSupplierProducts(supplierId) {
    try {
        const response = await fetch(`/api/v1/products?supplier_id=${supplierId}`);
        if (response.ok) {
            const data = await response.json();
            const productsList = document.getElementById('supplierProductsList');
            
            if (data.data && data.data.length > 0) {
                let productsHtml = '<div class="table-responsive"><table class="table table-sm">';
                productsHtml += '<thead><tr><th>Product</th><th>SKU</th><th>Price</th><th>Stock</th></tr></thead><tbody>';
                data.data.forEach(product => {
                    productsHtml += `
                        <tr>
                            <td><strong>${product.name}</strong></td>
                            <td><code>${product.sku}</code></td>
                            <td>$${product.price}</td>
                            <td><span class="badge bg-info">${product.quantity}</span></td>
                        </tr>
                    `;
                });
                productsHtml += '</tbody></table></div>';
                productsList.innerHTML = productsHtml;
            } else {
                productsList.innerHTML = '<p class="text-muted">No products from this supplier</p>';
            }
        }
    } catch (error) {
        document.getElementById('supplierProductsList').innerHTML = '<p class="text-danger">Error loading products</p>';
    }
}

function formatDate(dateString) {
    if (!dateString) return 'N/A';
    return new Date(dateString).toLocaleDateString();
}
</script>
@endpush