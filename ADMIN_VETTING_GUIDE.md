# Filament Admin Dashboard - Application Vetting Guide

## Overview

The NCEEIC Filament admin dashboard provides a comprehensive system for managing, vetting, scoring, and approving hospital solarization grant applications. The dashboard is designed for administrative staff to:

- View all submitted applications
- Score applications based on 8 criteria
- Track vetting and approval workflow
- Manage site visits
- Export application data

## Key Features

### 1. **Application Dashboard** (`/admin`)
The main dashboard provides:
- Quick stats on application status distribution
- Recent submissions list
- Qualified applications overview
- Status summary table with percentage breakdown

**Access:** Main navigation → Applications Dashboard

---

## 2. **Grant Applications Management** (`/admin/resources/grant-applications`)

### Viewing Applications
- List view shows all applications with key metrics
- Filter by status, ownership type, or qualification
- Sort by application date or score
- Search by application ID or hospital name

### Application Statuses

| Status | Description |
|--------|-------------|
| **Draft** | Application started but not submitted |
| **Submitted** | Application submitted, awaiting review |
| **Under Review** | Admin is actively vetting the application |
| **Shortlisted** | Application passed initial vetting |
| **Site Visit Scheduled** | On-site verification scheduled |
| **Approved** | Application approved for funding |
| **Rejected** | Application rejected |

### Scoring an Application

The scoring system uses 8 weighted criteria (total: 100 points):

1. **Ownership Score** (max 15 points)
   - Government facilities: Higher score
   - Private/Faith-based: Lower score

2. **Number of Beds** (max 10 points)
   - Larger facilities score higher

3. **ICU/OR Units** (max 15 points)
   - Presence of ICU or OR units

4. **Revenue Mix** (max 10 points)
   - Percentage of cash revenue

5. **Energy Use** (max 15 points)
   - Current energy consumption level

6. **ISO Compliance** (max 15 points)
   - ISO certification status

7. **Co-financing** (max 10 points)
   - Hospital commitment to co-finance

8. **Maintenance** (max 10 points)
   - Maintenance reserve policy

### How to Vet and Score an Application

1. **Open Application**
   - Click on an application in the list to edit it
   - Or use the "Vet & Score" button

2. **Review Application Data**
   - Hospital information (read-only, collapsed sections)
   - Revenue information
   - Energy consumption details
   - Management & compliance records
   - Financial capacity

3. **Score the Application**
   - In the "Vetting & Scoring" section, click the "Score Breakdown" tab
   - Enter points for each of the 8 criteria (max values shown)
   - Scores are calculated automatically
   - **Important:** Application must score ≥70% to be qualified

4. **Add Admin Notes**
   - Document your findings in "Internal Vetting Notes"
   - Record any concerns or observations
   - Explain scoring decisions

5. **Determine Site Visit Need**
   - Toggle "Site Visit Required?" if needed
   - Set scheduled date if required

6. **Set Status & Decision**
   - Change status to "Under Review" initially
   - Once scored, update to "Shortlisted" if qualified
   - Use approval/rejection actions to finalize

7. **Save Changes**
   - Click "Save" button
   - System automatically calculates total score and qualification

### Qualification Threshold
- **Minimum Score:** 70%
- Automatically calculated as: (Total Points ÷ 100) × 100
- Applications scoring <70% are marked as "Not Qualified"

### Bulk Actions
- Mark multiple applications as "Under Review"
- Bulk approve all qualified applications
- Export data to Excel/CSV

---

## 3. **Application Reviews** (`/admin/resources/application-reviews`)

Track all formal reviews conducted on applications.

### Creating a Review
1. Navigate to Application Reviews section
2. Click "Create" button
3. Select the application to review
4. Enter scoring and recommendation
5. Save the review

### Review Statuses
- **Recommended:** Approved for funding
- **Conditional:** Approved with conditions
- **Not Recommended:** Rejected

---

## 4. **Quick Actions in Application List**

| Action | When Available | Effect |
|--------|-----------------|---------|
| **Vet & Score** | Submitted or Under Review | Opens edit form |
| **Approve** | Shortlisted and Qualified | Sets status to Approved |
| **Reject** | Submitted/Under Review/Shortlisted | Sets status to Rejected |
| **Schedule Site Visit** | Shortlisted with site visit required | Sets status to Site Visit Scheduled |

---

## Workflow Example

### Step-by-Step Application Approval Process

1. **Application Submitted**
   - Hospital submits application
   - Status: "Submitted"
   - Navigation badge shows count

2. **Mark for Review**
   - Click application to open
   - Change status to "Under Review"
   - Save

3. **Vet & Score**
   - Review all application data
   - Enter scores for 8 criteria
   - Add internal notes
   - Determine if site visit needed
   - Save

4. **Decision**
   - If score ≥70%:
     - Status: "Shortlisted"
     - If site visit needed: Use "Schedule Site Visit" button
     - If ready: Use "Approve" button
   - If score <70%:
     - Use "Reject" button
     - Document reason in notes

5. **Site Visit (if required)**
   - Status: "Site Visit Scheduled"
   - Update site visit date
   - After visit, approve or reject

6. **Final Approval**
   - Status: "Approved"
   - Application added to funded list

---

## Admin Tips & Best Practices

### Scoring Guidelines
- Be consistent with scoring criteria
- Document reasoning in admin notes
- Consider contextual factors (state, facility type)
- Review similar applications for scoring consistency

### Vetting Checklist
- [ ] All required documents present (check Documents tab)
- [ ] Information is complete and accurate
- [ ] No red flags in management/compliance
- [ ] Financial capacity confirmed
- [ ] Co-financing commitment verified

### Document Verification
- Click "View Documents" button to see submitted files
- Verify:
  - CAC/Registration certificate
  - Energy audit report
  - State Ministry endorsement
  - Bank account verification

### Export & Reporting
- Use bulk action "Export" to download application list
- Includes scores, status, and submission dates
- Useful for board reports and statistics

### Navigation Badges
- Red badge on "Grant Applications" = pending applications
- Shows count of submitted + under review applications

---

## Common Tasks

### Find Applications Needing Review
1. Go to Grant Applications
2. Filter by Status = "Submitted"
3. Sort by "Submitted" date (oldest first)

### Find Qualified Applications
1. Go to Grant Applications
2. Filter by Qualified = Yes
3. Filter by Status = "Shortlisted"

### Find Site Visits Needed
1. Go to Grant Applications
2. Filter by Status = "Shortlisted"
3. Look for those with "Site Visit Required" marked

### Generate Approval List
1. Go to Grant Applications
2. Filter by Status = "Approved"
3. Use Export to download
4. Sort by score percentage

---

## Admin Account Setup

Only users with admin role can access the Filament dashboard.

To grant admin access:
1. Go to Users section
2. Edit user account
3. Set role to "Admin"
4. Save

---

## Support & Questions

For issues or questions about:
- **Application Data:** Check hospital information section
- **Scoring:** Refer to scoring guidelines above
- **System Issues:** Contact system administrator

---

## System Specifications

- **Minimum Passing Score:** 70%
- **Total Score Maximum:** 100 points
- **Number of Criteria:** 8
- **Application Statuses:** 7 (Draft, Submitted, Under Review, Shortlisted, Rejected, Site Visit Scheduled, Approved)
- **Bulk Approval:** Available for qualified applications only
