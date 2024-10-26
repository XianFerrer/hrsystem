// scripts.js

document.addEventListener('DOMContentLoaded', function() {
    // Example of form validation
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(event) {
            const employeeId = form.querySelector('select[name="employee_id"]');
            const date = form.querySelector('input[name="date"]');
            const clockIn = form.querySelector('input[name="clock_in"]');
            const clockOut = form.querySelector('input[name="clock_out"]');

            if (!employeeId.value || !date.value || !clockIn.value || !clockOut.value) {
                alert('Please fill in all fields.');
                event.preventDefault();
            }
        });
    }
});
