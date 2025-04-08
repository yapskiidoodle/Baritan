<!-- Activity Log Modal -->
<div class="modal fade" id="activityLogModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Admin Activity Log</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-container" style="max-height: 60vh;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Log ID</th>
                                <th>Admin ID</th>
                                <th>Action By</th>
                                <th>Action</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $logs = $conn->query("SELECT * FROM admin_activity_log ORDER BY created_at DESC");
                            if ($logs->num_rows > 0) {
                                while($log = $logs->fetch_assoc()) {
                                    echo '<tr>
                                        <td>'.$log['log_id'].'</td>
                                        <td>'.$log['admin_id'].'</td>
                                        <td>'.$log['action_by'].'</td>
                                        <td>'.$log['action'].'</td>
                                        <td>'.$log['created_at'].'</td>
                                    </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="5" class="text-center">No activity logs found</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to perform this action?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmActionButton">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- Deactivate Modal -->
<div class="modal fade" id="deactivateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Deactivate Admin Account</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deactivateForm" action="deactivate_admin.php" method="POST">
                <input type="hidden" id="deactivateAccountId" name="Account_ID">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="deactivateReason" class="form-label">Reason for Deactivation*</label>
                        <select class="form-select" id="deactivateReason" name="reason" required onchange="toggleOtherReason()">
                            <option value="" disabled selected>Select a reason</option>
                            <option value="Inactive account">Inactive account</option>
                            <option value="Policy violation">Policy violation</option>
                            <option value="Role change">Role change</option>
                            <option value="Security concerns">Security concerns</option>
                            <option value="Other">Other (please specify)</option>
                        </select>
                    </div>
                    
                    <div class="mb-3" id="otherReasonContainer" style="display: none;">
                        <label for="otherReasonDetails" class="form-label">Specify Reason*</label>
                        <textarea class="form-control" id="otherReasonDetails" name="other_reason" rows="2"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="chairmanPassword" class="form-label">Chairman Password*</label>
                        <input type="password" class="form-control" id="chairmanPassword" name="chairman_password" required>
                    </div>
                    
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> This action requires Chairman approval and will be logged.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm Deactivation</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Admin Modal -->
<div class="modal fade" id="addAdminModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addAdminForm" action="add_admin.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Username</label>
                        <input type="text" class="form-control" id="email" name="User_Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="Role" required onchange="updateAccountTypeOptions()">
                            <option value="" disabled selected>Select Role</option>
                            <option value="Chairman">Chairman</option>
                            <option value="Secretary">Secretary</option>
                            <option value="Treasurer">Treasurer</option>
                            <option value="Counselor">Counselor</option>
                            <option value="Lupon">Lupon</option>
                            <option value="SK">SK</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="accountType" class="form-label">Account Type</label>
                        <select class="form-select" id="accountType" name="Type" required>
                            <option value="" disabled selected>Select Role first</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="Password" required 
                               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}"
                               oninput="validatePassword()">
                        <div id="passwordHelp" class="form-text">
                            Password must contain:
                            <ul class="list-unstyled">
                                <li id="length"><i class="fas fa-times text-danger"></i> At least 8 characters</li>
                                <li id="lowercase"><i class="fas fa-times text-danger"></i> At least one lowercase letter</li>
                                <li id="uppercase"><i class="fas fa-times text-danger"></i> At least one uppercase letter</li>
                                <li id="number"><i class="fas fa-times text-danger"></i> At least one number</li>
                                <li id="special"><i class="fas fa-times text-danger"></i> At least one special character</li>
                            </ul>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="Status" required>
                            <option value="Activated" selected>Activated</option>
                            <option value="Deactivated">Deactivated</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="validateRoleBeforeSubmit()">Add Admin</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Role Limit Modal -->
<div class="modal fade" id="roleLimitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Role Limit Reached</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="roleLimitMessage">
                <!-- Message will be inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white justify-content-center">
                <h5 class="modal-title text-center w-100">Action Success</h5>
                <button type="button" class="btn-close btn-close-white position-absolute end-0 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="d-flex flex-column align-items-center">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <h4 id="successModalBody">Action completed successfully</h4>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Error</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="errorModalBody">
                <!-- Error message will be inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Role limits configuration
    const ROLE_LIMITS = {
        'Chairman': 1,
        'Secretary': 1,
        'Treasurer': 1,
        'Counselor': 12,
        'Lupon': 2,
        'SK': 1
    };

    // Update account type options based on selected role
    function updateAccountTypeOptions() {
        const role = document.getElementById('role').value;
        const accountTypeSelect = document.getElementById('accountType');
        
        accountTypeSelect.innerHTML = '';
        
        if (role === 'Chairman' || role === 'Secretary') {
            addOption(accountTypeSelect, 'Super Admin', 'Super Admin');
            addOption(accountTypeSelect, 'Admin', 'Admin');
            addOption(accountTypeSelect, 'Editor', 'Editor');
        } else if (role === 'Treasurer' || role === 'Counselor' || role === 'Lupon') {
            addOption(accountTypeSelect, 'Admin', 'Admin');
            addOption(accountTypeSelect, 'Editor', 'Editor');
        } else if (role === 'SK') {
            addOption(accountTypeSelect, 'Editor', 'Editor');
        } else {
            addOption(accountTypeSelect, '', 'Select Role first', true);
        }
    }

    function addOption(selectElement, value, text, disabled = false) {
        const option = document.createElement('option');
        option.value = value;
        option.textContent = text;
        if (disabled) option.disabled = true;
        if (value === '') option.selected = true;
        selectElement.appendChild(option);
    }

    // Toggle other reason textarea
    function toggleOtherReason() {
        const reasonSelect = document.getElementById('deactivateReason');
        const otherReasonContainer = document.getElementById('otherReasonContainer');
        otherReasonContainer.style.display = reasonSelect.value === 'Other' ? 'block' : 'none';
    }

    // Validate role before submission
    function validateRoleBeforeSubmit() {
        const role = document.getElementById('role').value;
        const passwordValid = validatePassword();
        
        if (!role) {
            alert('Please select a role');
            return;
        }
        
        if (!passwordValid) {
            alert('Please ensure your password meets all requirements');
            return;
        }

        fetch('get_role_counts.php')
            .then(response => response.json())
            .then(data => {
                const currentCount = data[role] || 0;
                const roleLimit = ROLE_LIMITS[role];
                
                if (currentCount >= roleLimit) {
                    const modal = new bootstrap.Modal(document.getElementById('roleLimitModal'));
                    document.getElementById('roleLimitMessage').textContent = 
                        `The ${role} role already has the maximum allowed number of accounts (${roleLimit}).`;
                    modal.show();
                } else {
                    document.getElementById('addAdminForm').submit();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error validating role limits. Please try again.');
            });
    }

    // Initialize account type options when modal is shown
    document.getElementById('addAdminModal').addEventListener('show.bs.modal', function() {
        updateAccountTypeOptions();
    });
</script>