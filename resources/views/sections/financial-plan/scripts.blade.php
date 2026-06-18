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

        // Calculate Readiness
        let readiness = totalCost > 0 ? Math.min(100, Math.round((totalFunding / totalCost) * 100)) : 0;
        
        document.getElementById('displayReadiness').textContent = readiness + '%';
        const circlePath = document.getElementById('readinessCirclePath');
        if(circlePath) circlePath.setAttribute('stroke-dasharray', `${readiness}, 100`);
        
        let svg = document.getElementById('readinessSvg');
        let riskBadge = document.getElementById('displayRisk');
        let riskWarnings = document.getElementById('riskWarnings');
        
        if (svg && riskBadge) {
            svg.classList.remove('green', 'orange', 'red');
            if (readiness < 50) {
                svg.classList.add('red');
                riskBadge.innerHTML = '<span class="fp-badge status-rejected"><i class="bi bi-exclamation-triangle"></i> High Risk</span>';
                if(riskWarnings) riskWarnings.style.display = 'block';
            } else if (readiness < 80) {
                svg.classList.add('orange');
                riskBadge.innerHTML = '<span class="fp-badge status-pending"><i class="bi bi-exclamation-circle"></i> Moderate Risk</span>';
                if(riskWarnings) riskWarnings.style.display = 'block';
            } else {
                svg.classList.add('green');
                riskBadge.innerHTML = '<span class="fp-badge status-approved"><i class="bi bi-shield-check"></i> Low Risk</span>';
                if(riskWarnings) riskWarnings.style.display = 'none';
            }
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

});

// --- Dynamic File Upload & Deletion for Specific Cost Items ---
function uploadItemFile(itemId) {
    const fileInput = document.getElementById('file_item_' + itemId);
    if (!fileInput || !fileInput.files.length) return;

    const statusEl = document.getElementById('item_ref_status_' + itemId);
    const containerEl = document.getElementById('item_ref_container_' + itemId);

    statusEl.style.display = 'block';
    if (containerEl) containerEl.style.display = 'none';

    const formData = new FormData();
    formData.append('document', fileInput.files[0]);
    formData.append('_token', document.querySelector('input[name="_token"]').value);

    fetch(`/financial-plan/item/${itemId}/upload`, {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        statusEl.style.display = 'none';
        if (data.success) {
            const shortName = data.file_name.length > 15 ? data.file_name.substring(0, 15) + '...' : data.file_name;
            containerEl.innerHTML = `
                <input type="file" id="file_item_${itemId}" class="d-none" onchange="uploadItemFile(${itemId})" accept=".pdf,image/*">
                <a href="${data.file_url}" target="_blank" class="text-primary fw-medium" style="font-size: 0.8rem;">
                    <i class="bi bi-file-earmark-check"></i> ${shortName}
                </a>
                <button type="button" class="btn-icon text-warning p-0 border-0 bg-transparent" onclick="document.getElementById('file_item_${itemId}').click()" title="Edit Reference" style="font-size: 0.85rem;">
                    <i class="bi bi-pencil-square"></i>
                </button>
                <button type="button" class="btn-icon text-danger p-0 border-0 bg-transparent" onclick="deleteItemFile(${itemId})" title="Delete Reference" style="font-size: 0.85rem;">
                    <i class="bi bi-trash"></i>
                </button>
            `;
            containerEl.style.display = 'flex';
        } else {
            alert('Failed to upload reference file.');
            containerEl.style.display = 'flex';
        }
    })
    .catch(error => {
        statusEl.style.display = 'none';
        if (containerEl) containerEl.style.display = 'flex';
        console.error('Error:', error);
        alert('An error occurred during upload.');
    });
}

function deleteItemFile(itemId) {
    if (!confirm('Delete this reference file?')) return;

    const statusEl = document.getElementById('item_ref_status_' + itemId);
    const containerEl = document.getElementById('item_ref_container_' + itemId);

    statusEl.style.display = 'block';
    if (containerEl) containerEl.style.display = 'none';

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
        if (data.success) {
            containerEl.innerHTML = `
                <input type="file" id="file_item_${itemId}" class="d-none" onchange="uploadItemFile(${itemId})" accept=".pdf,image/*">
                <button type="button" class="btn btn-sm btn-outline-secondary py-1 px-2 d-flex align-items-center gap-1" onclick="document.getElementById('file_item_${itemId}').click()" style="font-size: 0.72rem; border-radius: 4px;">
                    <i class="bi bi-upload"></i> Upload Source
                </button>
            `;
            containerEl.style.display = 'flex';
        } else {
            alert('Failed to delete reference file.');
            containerEl.style.display = 'flex';
        }
    })
    .catch(error => {
        statusEl.style.display = 'none';
        if (containerEl) containerEl.style.display = 'flex';
        console.error('Error:', error);
        alert('An error occurred while deleting.');
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
</script>
