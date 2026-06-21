<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Auto-save & Calculation Setup
    const form = document.getElementById('financialPlanForm');
    if (!form) return;

    const itemCostInputs = document.querySelectorAll('.calc-item-cost');
    const itemScholInputs = document.querySelectorAll('.calc-item-schol');

    // Attach listeners for auto-calc
    const allInputs = [...itemCostInputs, ...itemScholInputs];
    allInputs.forEach(input => {
        input.addEventListener('input', debounce(calculateTotals, 500));
        input.addEventListener('change', calculateTotals);
    });

    function calculateTotals() {
        // Calculate Gaps per item
        let totalCost = 0;
        let totalFunding = 0;
        
        itemCostInputs.forEach(costInput => {
            const id = costInput.getAttribute('data-id');
            const cost = parseFloat(costInput.value) || 0;
            const schol = parseFloat(document.querySelector(`.calc-item-schol[data-id="${id}"]`).value) || 0;
            
            const gap = schol - cost;
            const gapEl = document.getElementById(`gap_${id}`);
            if (gapEl) {
                gapEl.textContent = (gap >= 0 ? '+' : '') + formatNumber(gap);
                gapEl.className = gap >= 0 ? 'gap-amount fw-bold text-success' : 'gap-amount fw-bold text-danger';
            }
            
            totalCost += cost;
            totalFunding += schol;
        });

        const fundingGap = totalFunding - totalCost;
        
        // Update DOM
        document.getElementById('displayTotalCost').textContent = formatNumber(totalCost);
        document.getElementById('displayTotalFunding').textContent = formatNumber(totalFunding);
        
        const gapEl = document.getElementById('displayFundingGap');
        if (gapEl) {
            gapEl.textContent = (fundingGap >= 0 ? '+' : '') + formatNumber(fundingGap);
            gapEl.className = fundingGap >= 0 ? 'text-success' : 'text-danger';
        }

        // Auto-save
        saveDraft();
    }

    function saveDraft() {
        const formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Draft saved automatically');
        })
        .catch(error => console.error('Error saving draft:', error));
    }

    // --- Form submit (Save button) ---
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = this.querySelector('.fp-btn-save');
        const ogText = btn.innerHTML;
        btn.innerHTML = '<i class="spinner-border spinner-border-sm"></i> Saving...';
        btn.disabled = true;

        fetch(this.action, {
            method: 'POST',
            body: new FormData(this),
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            btn.innerHTML = '<i class="bi bi-check2"></i> Saved';
            setTimeout(() => { btn.innerHTML = ogText; btn.disabled = false; }, 2000);
        })
        .catch(error => {
            console.error('Error:', error);
            btn.innerHTML = ogText;
            btn.disabled = false;
        });
    });

    // --- Final Submit form validation ---
    const submitForm = document.getElementById('financialPlanSubmitForm');
    if (submitForm) {
        submitForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate if all required inputs in the main form are filled
            let allFilled = true;
            const requiredInputs = form.querySelectorAll('input[required]');
            
            requiredInputs.forEach(input => {
                if (input.value.trim() === '') {
                    allFilled = false;
                    input.style.border = '2px solid #dc3545'; // Highlight empty fields
                } else {
                    input.style.border = ''; // Reset border
                }
            });

            if (!allFilled) {
                Swal.fire({ title: 'Incomplete Data', text: 'There are empty budget columns. Please fill all columns (enter 0 if not applicable) before submitting.', icon: 'warning', confirmButtonColor: '#3b82f6' });
                return false;
            }

            Swal.fire({
                title: 'Submit Financial Plan?',
                text: "Are you sure you want to submit this Financial Plan? Data cannot be changed after submission.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const ogBtnHtml = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="spinner-border spinner-border-sm"></i> Submitting...';
                    submitBtn.disabled = true;

                    const formData = new FormData(form);
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.submit();
                        } else {
                            Swal.fire({ title: 'Error', text: 'Error saving data before submission: ' + (data.message || 'Unknown error'), icon: 'error', confirmButtonColor: '#3b82f6' });
                            submitBtn.innerHTML = ogBtnHtml;
                            submitBtn.disabled = false;
                        }
                    })
                    .catch(error => {
                        Swal.fire({ title: 'Connection Error', text: 'Failed to connect to the server before submission. Please try again.', icon: 'error', confirmButtonColor: '#3b82f6' });
                        console.error(error);
                        submitBtn.innerHTML = ogBtnHtml;
                        submitBtn.disabled = false;
                    });
                }
            });
        });
    }

});

// --- Dynamic File Upload & Deletion for Specific Cost Items ---
function uploadItemFile(itemId) {
    const fileInput = document.getElementById('file_item_' + itemId);
    if (!fileInput || !fileInput.files.length) return;

    const file = fileInput.files[0];

    // Client-side type validation
    const allowed = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'];
    if (!allowed.includes(file.type)) {
        Swal.fire({ title: 'Invalid File', text: 'Invalid file type. Only PDF, JPG, and PNG files are allowed.', icon: 'error', confirmButtonColor: '#3b82f6' });
        fileInput.value = '';
        return;
    }

    // Max 5MB
    if (file.size > 5 * 1024 * 1024) {
        Swal.fire({ title: 'File Too Large', text: 'File is too large. Maximum allowed size is 5 MB.', icon: 'warning', confirmButtonColor: '#3b82f6' });
        fileInput.value = '';
        return;
    }

    const statusEl = document.getElementById('item_ref_status_' + itemId);
    const containerEl = document.getElementById('item_ref_container_' + itemId);

    statusEl.style.display = 'block';
    containerEl.style.display = 'none';

    const formData = new FormData();
    formData.append('document', file);
    formData.append('_token', document.querySelector('input[name="_token"]').value);

    fetch(`/financial-plan/item/${itemId}/upload`, {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        statusEl.style.display = 'none';
        containerEl.style.display = '';
        if (data.success) {
            const ext = data.file_name.split('.').pop().toLowerCase();
            const isImg = ['jpg','jpeg','png','gif','webp'].includes(ext);
            const icon = isImg
                ? '<i class="bi bi-file-earmark-image text-success"></i>'
                : '<i class="bi bi-file-earmark-pdf text-danger"></i>';
            const shortName = data.file_name.length > 14 ? data.file_name.substring(0, 14) + '\u2026' : data.file_name;
            containerEl.innerHTML = `
                <input type="file" id="file_item_${itemId}" class="d-none" onchange="uploadItemFile(${itemId})" accept=".pdf,.jpg,.jpeg,.png">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="${data.file_url}" target="_blank" class="fp-ref-file-link" title="${data.file_name}">
                        ${icon}<span>${shortName}</span>
                    </a>
                    <button type="button" class="btn-icon text-warning p-0 border-0 bg-transparent" onclick="document.getElementById('file_item_${itemId}').click()" title="Replace file" style="font-size:0.82rem;">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button type="button" class="btn-icon text-danger p-0 border-0 bg-transparent" onclick="deleteItemFile(${itemId})" title="Delete file" style="font-size:0.82rem;">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;
        } else {
            Swal.fire({ title: 'Upload Failed', text: 'Failed to upload file. Please try again.', icon: 'error', confirmButtonColor: '#3b82f6' });
        }
    })
    .catch(error => {
        statusEl.style.display = 'none';
        containerEl.style.display = '';
        console.error('Error:', error);
        Swal.fire({ title: 'Error', text: 'An error occurred during upload.', icon: 'error', confirmButtonColor: '#3b82f6' });
    });
}

function deleteItemFile(itemId) {
    Swal.fire({
        title: 'Delete Reference File?',
        text: "Are you sure you want to delete this reference file?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#9ca3af',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (!result.isConfirmed) return;

        const statusEl = document.getElementById('item_ref_status_' + itemId);
        const containerEl = document.getElementById('item_ref_container_' + itemId);

        statusEl.style.display = 'block';
        containerEl.style.display = 'none';

        fetch(`/financial-plan/item/${itemId}/delete-file`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            statusEl.style.display = 'none';
            containerEl.style.display = '';
            if (data.success) {
                containerEl.innerHTML = `
                    <button type="button" class="fp-upload-ref-btn" onclick="document.getElementById('file_item_${itemId}').click()">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <span>Upload</span>
                        <small>PDF / Image</small>
                    </button>
                `;
            } else {
                Swal.fire({ title: 'Delete Failed', text: 'Failed to delete the file.', icon: 'error', confirmButtonColor: '#3b82f6' });
            }
        })
        .catch(error => {
            statusEl.style.display = 'none';
            containerEl.style.display = '';
            console.error('Error:', error);
            Swal.fire({ title: 'Error', text: 'An error occurred while deleting.', icon: 'error', confirmButtonColor: '#3b82f6' });
        });
    });
}

// Helpers
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => { clearTimeout(timeout); func(...args); };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Format number (en-US locale, 2 fraction digits)
function formatNumber(num) {
    return Number(num).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function uploadExcelFile() {
    const fileInput = document.getElementById('import_excel_file');
    const file = fileInput.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('excel_file', file);

    const overlay = document.createElement('div');
    overlay.style.position = 'fixed';
    overlay.style.top = '0'; overlay.style.left = '0'; overlay.style.width = '100vw'; overlay.style.height = '100vh';
    overlay.style.backgroundColor = 'rgba(255,255,255,0.7)';
    overlay.style.zIndex = '9999';
    overlay.style.display = 'flex';
    overlay.style.justifyContent = 'center';
    overlay.style.alignItems = 'center';
    overlay.innerHTML = '<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div><span class="ms-3 fw-bold">Importing Excel...</span>';
    document.body.appendChild(overlay);

    fetch(`{{ route('financial-plan.import-excel', $plan->id) }}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({ title: 'Success', text: data.message, icon: 'success', confirmButtonColor: '#3b82f6' }).then(() => {
                window.location.reload();
            });
        } else {
            Swal.fire({ title: 'Import Failed', text: data.message || 'Error importing file.', icon: 'error', confirmButtonColor: '#3b82f6' });
            document.body.removeChild(overlay);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({ title: 'Error', text: 'An unexpected error occurred.', icon: 'error', confirmButtonColor: '#3b82f6' });
        document.body.removeChild(overlay);
    });
    
    fileInput.value = ''; // Reset
}
</script>
