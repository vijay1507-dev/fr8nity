class MemberSalesReport {
    constructor() {
        this.dateFromPicker = null;
        this.dateToPicker = null;
        this.form = document.getElementById('memberExportForm');
        this.downloadBtn = document.getElementById('downloadBtn');
        this.init();
    }

    init() {
        this.initializeDatePickers();
        this.handleFormSubmit();
    }

    initializeDatePickers() {
        // Initialize date pickers with Flatpickr
        this.dateFromPicker = flatpickr("#date_from", {
            dateFormat: "Y-m-d",
            maxDate: "today",
            onChange: (selectedDates, dateStr) => {
                if (dateStr) {
                    this.dateToPicker.set('minDate', dateStr);
                }
            }
        });

        this.dateToPicker = flatpickr("#date_to", {
            dateFormat: "Y-m-d",
            maxDate: "today"
        });
    }

    validateForm() {
        const dateFromInput = document.getElementById('date_from');
        const dateToInput = document.getElementById('date_to');
        const dateFrom = dateFromInput.value;
        const dateTo = dateToInput.value;

        let isValid = true;

        // Reset feedback
        dateFromInput.classList.remove('is-invalid');
        dateToInput.classList.remove('is-invalid');

        if (!dateFrom) {
            dateFromInput.classList.add('is-invalid');
            isValid = false;
        }

        if (!dateTo) {
            dateToInput.classList.add('is-invalid');
            isValid = false;
        }

        if (dateFrom && dateTo && new Date(dateFrom) > new Date(dateTo)) {
            dateToInput.classList.add('is-invalid');
            alert("End date cannot be earlier than start date.");
            isValid = false;
        }

        return isValid;
    }

    handleFormSubmit() {
        this.form.addEventListener('submit', (e) => {
            if (!this.validateForm()) {
                e.preventDefault(); // Stop form submission
            }
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function () {
    new MemberSalesReport();
});
