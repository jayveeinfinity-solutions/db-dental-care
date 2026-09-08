# DB Dental Care - Project Revision Tasks
> **Source Material:** `Revised-Errors-2.pdf`
> **Purpose:** Structured prompt and task list for AI Coding Agent.

## 1. Appointment Booking System Updates

### 1.1. Date and Time Availability
*   **Disable Past Dates/Times:** Update the date/time picker to disable (gray out) any dates and times that have already passed [cite: 1].
*   **Disable Booked Slots:** Any time slot that is currently booked, pending, or approved for another patient must be unavailable and grayed out in the picker [cite: 1].
*   **Agent Task:** Update the frontend datepicker constraints and ensure backend validation strictly prevents double-booking and past-booking.

### 1.2. Service Selection (Multiple Services)
*   **Checkbox Conversion:** Refactor the "Select service" input field on the appointment booking modal. Change it from a single-select dropdown to a **checkbox list** to allow patients to book multiple services at once [cite: 1].
*   **Agent Task:** Update the form state to handle an array of `service_ids` instead of a single integer/string.

### 1.3. Dynamic Time Allotment
*   **Calculate Appointment Duration:** Implement logic to block out time based on the services selected [cite: 1]:
    *   Consultation: 10 minutes [cite: 1].
    *   General Services: 30 minutes to 1 hour [cite: 1].
    *   Extractions: Variable duration [cite: 1].
*   **Agent Task:** Update the availability logic to check if there are consecutive free slots that match the total calculated duration of the selected services.

---

## 2. Patient Records & History UI

### 2.1. Procedure History Interface
*   **New UI Component:** Build a new UI section dedicated to viewing a patient's historical records of consultations, treatments, and procedures [cite: 1].
*   **Detailed Logging:** The admin must be able to input specific medical history per procedure [cite: 1]. The data schema for a completed procedure must include:
    *   Date of the procedure [cite: 1].
    *   Specific procedure performed [cite: 1].
    *   Target specifics (e.g., the exact tooth extracted or filled) [cite: 1].
    *   Corresponding amount/cost of the procedure [cite: 1].
*   **Future Proofing:** Keep the UI extensible for a potential "Dental Chart" integration [cite: 1].

### 2.2. Patient List Enhancements
*   **Filters:** Implement list filters (e.g., Today, This Week, This Month) on the patient/appointment data tables [cite: 1].
*   **Patient IDs:** Ensure a unique ID number is displayed for each patient [cite: 1].
*   **Label Updates:** Globally replace the abbreviation "PAT" with "PX" (Medical standard for Patient) [cite: 1].

---

## 3. Dashboard & Admin View

### 3.1. Daily Schedule Summary
*   **Today's Appointments:** Create a summary view showing the sequence of appointments specifically for the current day [cite: 1].
*   **Capacity Planning:** The UI should clearly indicate the clinic's schedule density so admins know exactly how many walk-in patients they can accommodate [cite: 1].

---

## 4. Notifications & Documents

### 4.1. Automated Notifications
*   **Status Alerts:** Integrate an event listener to notify the client (via email/SMS/system notification) whenever their appointment status is moved to **Approved** or **Cancelled** [cite: 1].

### 4.2. Document Generation
*   **PDF Restrictions:** Ensure the PDF generation feature is strictly applied *only* for **Dental Certificates** [cite: 1].
