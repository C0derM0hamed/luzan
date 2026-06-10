# Future Architecture — Luzan Medical Center

This document describes how the current Laravel monolith can be extended for planned future features. **None of these are implemented yet.**

## Current Foundation

- **Auth:** Session-based `web` guard on `users` table with `is_admin` boolean
- **Patients:** Appointment data stored with PII (`national_id`, `mobile`) but no patient accounts
- **API:** No `routes/api.php` — all server-rendered Blade

## Patient Login & Patient Portal

### Recommended extension

1. Add `role` enum/string column to `users`: `admin`, `patient` (or separate `patients` table linked via `user_id`)
2. Add patient registration/login routes under `/patient/login` with dedicated middleware `patient`
3. Link appointments to `patient_id` once accounts exist (nullable FK during migration)
4. Patient dashboard views: upcoming appointments, profile, branch info

### Existing hooks

- `User` model + Laravel auth already configured
- `Appointment` model can gain `belongsTo(Patient::class)` or `belongsTo(User::class)`

## Medical Reports

### Recommended schema (future)

```
medical_reports
  - id
  - patient_id (FK)
  - doctor_id (FK, nullable)
  - title
  - report_date
  - file_path (storage)
  - notes
  - created_at, updated_at
```

- Admin/staff upload via admin panel
- Patients view/download via patient portal with authorization policy

## Lab Results

### Recommended schema (future)

```
lab_results
  - id
  - patient_id (FK)
  - test_name
  - result_date
  - result_data (JSON or text)
  - file_path (nullable PDF)
  - status (pending, ready)
  - created_at, updated_at
```

- Integrate with المختبر service specialty
- Optional HL7/FHIR API layer if external lab systems are added

## API Layer (optional)

For mobile apps or SPA patient portal:

- Add `routes/api.php` with Sanctum token auth
- Version endpoints: `/api/v1/appointments`, `/api/v1/reports`, `/api/v1/lab-results`
- Reuse existing Eloquent models and policies

## Security Considerations for Future Features

- Encrypt sensitive PII at rest (`national_id`)
- Audit log table for admin access to patient records
- Role-based policies (`PatientPolicy`, `MedicalReportPolicy`)
- File storage outside `public/` with signed URLs for downloads

## Migration Path

1. Phase 1: Add `role` to users + patient registration
2. Phase 2: Link existing appointments to patient records by matching `national_id` + `mobile`
3. Phase 3: Medical reports + lab results tables and admin upload
4. Phase 4: Patient portal UI + optional API

No database changes for these features are included in the current codebase by design.
