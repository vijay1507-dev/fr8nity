/**
 * Sales Report JavaScript Module
 * Handles sales report functionality including preview and export
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('SalesReport script loaded and DOM ready');
    
    // DOM Elements
    const memberSelect = document.getElementById('member_id');
    const exportForm = document.getElementById('exportForm');
    const downloadBtn = document.getElementById('downloadBtn');
    const dateFromInput = document.getElementById('date_from');
    const dateToInput = document.getElementById('date_to');

    // Check if all required DOM elements exist
    const requiredElements = [
        'member_id', 'exportForm', 'downloadBtn', 'date_from', 'date_to'
    ];
    
    const missingElements = requiredElements.filter(id => !document.getElementById(id));
    if (missingElements.length > 0) {
        console.error('Missing required DOM elements:', missingElements);
        return;
    }

    // Routes (will be set from the view)
    let routes = {
        export: '',
        members: ''
    };

    /**
     * Initialize the module with routes
     */
    window.SalesReport = {
        init: function(routeConfig) {
            console.log('SalesReport initializing with routes:', routeConfig);
            routes = routeConfig;
            console.log('Routes initialized:', routes);
            
            // Verify all required routes are present
            if (!routes.members || !routes.export) {
                console.error('Missing required routes:', {
                    members: !!routes.members,
                    export: !!routes.export
                });
            } else {
                console.log('All routes successfully initialized');
                // Initialize the page with members
                initializePage();
            }
        }
    };

    /**
     * Function to show no records message
     */
    function showNoRecordsMessage(message) {
        // Create a more user-friendly alert using Bootstrap alert
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-warning alert-dismissible fade show position-fixed';
        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; max-width: 400px;';
        alertDiv.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div>
                    <strong>No Records Found</strong><br>
                    <small>${message}</small>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        document.body.appendChild(alertDiv);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }

    /**
     * Load members when page loads
     */
    function initializePage() {
        // Check if routes are initialized
        if (!routes.members) {
            console.error('Routes not initialized. Please wait for initialization.');
            return;
        }
        loadMembers();
    }

    /**
     * Load members from API
     */
    function loadMembers() {
        // Double-check routes are available
        if (!routes.members) {
            console.error('Members route not available');
            memberSelect.innerHTML = '<option value="">Routes not initialized</option>';
            return;
        }

        memberSelect.innerHTML = '<option value="">Loading members...</option>';
        
        fetch(routes.members)
            .then(response => response.json())
            .then(data => {
                memberSelect.innerHTML = '<option value="">Choose a member...</option>';
                data.forEach(member => {
                    const option = document.createElement('option');
                    option.value = member.id;
                    option.textContent = member.display_name;
                    memberSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading members:', error);
                memberSelect.innerHTML = '<option value="">Error loading members</option>';
            });
    }

    /**
     * Date validation
     */
    dateFromInput.addEventListener('change', function() {
        dateToInput.min = this.value;
        if (dateToInput.value && dateToInput.value < this.value) {
            dateToInput.value = this.value;
        }
    });

    dateToInput.addEventListener('change', function() {
        dateFromInput.max = this.value;
    });

    /**
     * Form submission
     */
    exportForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Check if routes are initialized
        if (!routes.export) {
            console.error('Routes not initialized. Please wait for initialization.');
            alert('System not ready. Please refresh the page and try again.');
            return;
        }
        
        // Validate member selection
        if (!memberSelect.value) {
            memberSelect.classList.add('is-invalid');
            return;
        } else {
            memberSelect.classList.remove('is-invalid');
        }

        performExport();
    });

    /**
     * Perform export function
     */
    function performExport() {
        console.log('Performing export...');
        
        // Show loading indicator
        downloadBtn.disabled = true;
        downloadBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Preparing...';



        // Create form data from the form
        const formData = new FormData(exportForm);
        console.log('Using form data');
        
        console.log('Export URL:', exportForm.action);

        // Submit form for download
        fetch(routes.export, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => {
            console.log('Response received:', response);
            if (!response.ok) {
                // Check if it's a 404 (no records found)
                if (response.status === 404) {
                    return response.json().then(data => {
                        throw new Error(data.message || 'No records found for the selected criteria.');
                    });
                }
                console.error('Response not ok:', response.status, response.statusText);
                throw new Error(`Network response was not ok: ${response.status} ${response.statusText}`);
            }
            return response.blob();
        })
        .then(blob => {
            console.log('Blob received:', blob);
            // Create download link
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            
            // Get filename from Content-Disposition header or create default
            let selectedMemberText = 'unknown_member';
            if (memberSelect.selectedIndex >= 0 && memberSelect.options[memberSelect.selectedIndex]) {
                selectedMemberText = memberSelect.options[memberSelect.selectedIndex].text;
            }
            const timestamp = new Date().toISOString().slice(0, 19).replace(/[:-]/g, '_');
            a.download = `sales_report_${selectedMemberText.replace(/[^a-zA-Z0-9]/g, '_').toLowerCase()}_${timestamp}.csv`;
            
            console.log('Download filename:', a.download);
            
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
            
            console.log('Download initiated successfully');
            
            // Reset form and clear validation
            exportForm.reset();
            memberSelect.classList.remove('is-invalid');
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Check if it's a "no records found" error
            if (error.message.includes('No records found') || error.message.includes('no report found')) {
                // Show a more user-friendly message for no records
                showNoRecordsMessage(error.message);
            } else {
                alert('Error generating report. Please try again.');
            }
        })
        .finally(() => {
            // Hide loading indicator
            downloadBtn.disabled = false;
            downloadBtn.innerHTML = '<i class="bi bi-download me-2"></i>Download CSV Report';
            

        });
    }
});
